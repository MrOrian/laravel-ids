<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserControllerAPI;
use Tymon\JWTAuth\Facades\JWTAuth;
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

Route::prefix('')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:api', 'isAdmin'])->group(function() {
        Route::get('/user', [UserControllerAPI::class, 'index']);
        Route::get('/user/all', [UserControllerAPI::class, 'getAll']);
        Route::post('/user', [UserControllerAPI::class, 'createUser']);
        Route::put('/user/{id}', [UserControllerAPI::class, 'updateUser']);
        Route::delete('/user/{id}', [UserControllerAPI::class, 'deleteUser']);
    });
});

