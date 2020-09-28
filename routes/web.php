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

Route::get('admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'loginIndex'])->name('admin.login');
Route::post('admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'loginProccess'])->name('admin.login-proccess');

Route::middleware('logged')->group(function() {
    Route::get('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logoutProccess'])->name('admin.logout');
    
    Route::prefix('admin')->as('admin.')->group(function(){
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        Route::prefix('users')->as('users.')->group(function(){
            Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'getIndex'])->name('index');
            Route::get('/detail', [\App\Http\Controllers\Admin\UserController::class, 'getDetail'])->name('detail');
            Route::get('/edit', [\App\Http\Controllers\Admin\UserController::class, 'getEdit'])->name('edit');
            Route::get('/create', [\App\Http\Controllers\Admin\UserController::class, 'getCreate'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'postStore'])->name('store');
            Route::put('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'putUpdate'])->name('update');
        });
    });
    
  });