<?php

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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\Tipo;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    return response()->json(['ok'], 200);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('me', [AuthController::class, 'me'])->name('me');
    });
});

Route::group(['middleware' => ['auth:api', 'tipo:' . Tipo::ADMIN]], function () {
    Route::get('users', [UserController::class, 'index'])->name('index');
    Route::post('users', [UserController::class, 'store'])->name('store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('show');
    Route::match(['PUT', 'PATCH'], 'users/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('destroy');
});
