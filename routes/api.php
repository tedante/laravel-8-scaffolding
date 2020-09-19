<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function() {

    // Route::post('upload', 'StorageController@upload');

    Route::middleware(['json'])->group(function() {
        Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login'])->name('login');
        Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register'])->name('register');
      
        Route::middleware('auth:api')->group(function() {
            
        });
    });

});

