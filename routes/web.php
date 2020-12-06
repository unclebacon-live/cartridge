<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\AdminController;

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

function apply_routes() {
    Route::get('/games', [GameController::class, 'index'])->name('games');
    Route::get('/games/{slug}', [GameController::class, 'show'])->name('game');
    
    Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms');
    Route::get('/platforms/{slug}', [PlatformController::class, 'show'])->name('platform');
    
    Route::get('/files/{id}/{filename}', [FileController::class, 'download'])->name('download');
}

Route::get('/admin', [AdminController::class, 'index'])->middleware('admin')->name('admin_dashboard');

if(config('cartridge.allow_guests')) {
    Route::get('/', function () {
        return view('welcome');
    });

    apply_routes();
} else {
    Route::get('/', function () {
        return redirect('home');
    });

    Route::middleware('auth')->group(function() {
        apply_routes();
    });
}

$auth_options = [
    'reset' => false
];

if(!config('cartridge.allow_registration')) {
    $auth_options['register'] = false;
}

Auth::routes($auth_options);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
