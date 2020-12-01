<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

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
Route::get('/games', [GameController::class, 'index'])->name('games');
Route::get('/games/{slug}', [GameController::class, 'show'])->name('game');

Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms');
Route::get('/platforms/{slug}', [PlatformController::class, 'show'])->name('platform');

Route::get('/files/{id}/{filename}', [FileController::class, 'download'])->name('download');

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('dashboard');
})->name('dashboard');
