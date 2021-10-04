<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::group([
    // 'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('me', [AuthController::class, 'me'])->name('me');

    Route::get('users', [UserController::class, 'index'])->name('index');
    Route::get('users/{id}', 'UserController@show')->name('show');
    Route::post('users', 'UserController@create')->name('create');
    Route::post('users/{id}', 'UserController@update')->name('update');
});

