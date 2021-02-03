<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/form', [App\Http\Controllers\FormController::class, 'show'])->name('form');

Route::post('/dades', [App\Http\Controllers\DadesController::class, 'show'])->name('dades');

Route::post('/form', [App\Http\Controllers\FormController::class, 'postform'])->name('postform');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/dadesTable', [App\Http\Controllers\JuegoController::class, 'db']);

Route::get('/createTable', [App\Http\Controllers\JuegoController::class, 'storeForm'])->name('storeForm');

Route::post('createTable', [App\Http\Controllers\JuegoController::class, 'store']);

Route::get('editForm/{id}', [App\Http\Controllers\JuegoController::class, 'editForm']);

Route::post('editTable/{id}', [App\Http\Controllers\JuegoController::class, 'edit']);

Route::get('delete/{id}', [App\Http\Controllers\JuegoController::class, 'delete']);


require __DIR__.'/auth.php';

