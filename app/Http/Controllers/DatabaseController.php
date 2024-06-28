<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $query->where('connectionname', 'LIKE', '%' . request()->q . '%');
        })->paginate(request()->per_page);
        return Inertia::render('Database', [
            'data' => $data,
        ]);
        //return response()->json($data);
    }
}
