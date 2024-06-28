<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\ListDatabase;
use Inertia\Inertia;
use Inertia\Response;

class DatabaseController extends Controller
{
    public function index(){
        /*
        orderBy(request()->sortby, request()->sortbydesc)
        ->
        */
        $data = ListDatabase::when(request()->q, function($query) {
            $query->where('connection', 'LIKE', '%' . request()->q . '%');
        })->paginate(request()->per_page);
        return Inertia::render('Database/Index', [
            'data' => $data,
        ]);
    }
    public function add(){
        request()->validate([
            'connection' => 'required',
            'host' => 'required',
            'port' => 'required',
            'name' => 'required',
            'username' => 'required',
        ]);
        if(request()->id){
            $ListDatabase = ListDatabase::find(request()->id);
        } else {
            $ListDatabase = new ListDatabase;
        }
        $ListDatabase->connection = request()->connection;
        $ListDatabase->host = request()->host;
        $ListDatabase->port = request()->port;
        $ListDatabase->name = request()->name;
        $ListDatabase->username = request()->username;
        $ListDatabase->password = request()->password;
        $ListDatabase->save();
        return to_route('database.index');
    }
    public function detail($id){
        $find = ListDatabase::find($id);
        $connection = ($find->connection == 'mysql') ? 'dinamyc_mysql' : 'dinamyc_mysql';
        try {
            if($find->connection == 'mysql'){
                Config::set('database.connections.'.$connection, [
                    "driver" => 'mysql',
                    "url" => null,
                    "host" => $find->host,
                    "database" => $find->name,
                    "username" => $find->username,
                    "password" => $find->password,
                    "unix_socket" => "",
                    "charset" => "utf8mb4",
                    "collation" => "utf8mb4_unicode_ci",
                    "prefix" => "",
                    "prefix_indexes" => true,
                    "strict" => true,
                    "engine" => null,
                    "options" => [],
                ]);
            } else {
                Config::set('database.connections.'.$connection, [
                    'driver' => 'pgsql',
                    'url' => NULL,
                    'host' => $find->host,
                    'port' => $find->port,
                    'database' => $find->name,
                    'username' => $find->username,
                    'password' => $find->password,
                    'charset' => 'utf8',
                    'prefix' => '',
                    'prefix_indexes' => true,
                    'search_path' => 'public',
                    'sslmode' => 'prefer',
                ]);
            }
            $dbconnect = DB::connection($connection)->getPDO();
            DB::purge($connection);
            $listTables = Schema::connection($connection)->getConnection()->getDoctrineSchemaManager()->listTableNames();
            $tables = [];
            foreach($listTables as $table){
                $doctrineTable = Schema::connection($connection)->getConnection()->getDoctrineSchemaManager()->listTableDetails($table);
                $fieldName = [];
                $fieldType = [];
                foreach ($doctrineTable->getColumns() as $column) {
                    $fieldName[] = $column->getName();
                    $fieldType[] = $column->getType()->getName();
                }         
                $tables[] = [
                    'table' => $table,
                    'fieldName' => $fieldName,
                    'fieldType' => $fieldType,
                ];
            }
            $data = [
                'success' => TRUE,
                'connection' => $connection,
                'database' => $find->name,
                'listTables' => $tables,
                'message' => NULL,
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'success' => FALSE,
                'connection' => $connection,
                'database' => $find->name,
                'listTables' => [],
                'message' => $th->getMessage(),
            ];
        }
        return Inertia::render('Database/Koneksi', [
            'id' => $id,
            'data' => $data,
        ]);
    }
    public function destroy($id){
        $find = ListDatabase::find($id);
        $find->delete();
        return to_route('database.index');        
    }
}
