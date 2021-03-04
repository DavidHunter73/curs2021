<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuroController;

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
})->name('public');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('muro', [MuroController::class, 'index'])->name("muro");

Route::post('send', [MuroController::class, 'send'])->name("send");

Route::get('get', [MuroController::class, 'get'])->name("get");

require __DIR__.'/auth.php';
