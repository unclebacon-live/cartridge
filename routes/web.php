<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserAdminController;

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

// Auth
$auth_options = [
    'reset' => false
];

if(!config('cartridge.allow_registration')) {
    $auth_options['register'] = false;
}

Auth::routes($auth_options);

// Admin
Route::middleware('admin')->group(function() {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin_dashboard');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin_settings');
    Route::get('/admin/users', [UserAdminController::class, 'index'])->name('admin_users');
});

// Protected areas
Route::middleware('auth')->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/games', [GameController::class, 'index'])->name('games');
    Route::get('/games/{slug}', [GameController::class, 'show'])->name('game');
    
    Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms');
    Route::get('/platforms/{slug}', [PlatformController::class, 'show'])->name('platform');
    
    Route::get('/files/{id}/{filename}', [FileController::class, 'download'])->name('download');
});