<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DatabaseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'database'], function () {
        Route::get('/', [DatabaseController::class, 'index'])->name('database.index');
        Route::post('/add', [DatabaseController::class, 'add'])->name('database.add');
        Route::post('/cek-koneksi', [DatabaseController::class, 'cekKoneksi'])->name('database.cek-koneksi');
        Route::get('/detail/{id}', [DatabaseController::class, 'detail'])->name('database.detail');
        Route::delete('/destroy/{id}', [DatabaseController::class, 'destroy'])->name('database.destroy');
    });
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/config', function () {
    dd(config('database'));
});
require __DIR__.'/auth.php';
