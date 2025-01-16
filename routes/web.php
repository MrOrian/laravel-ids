<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\UserControllerAPI;
use Tymon\JWTAuth\Facades\JWTAuth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->get('/users/search', [UserController::class, 'searchByName'])->name('users.searchByName');
Route::middleware(['auth', 'isAdmin'])->resource('users', UserController::class);
Route::middleware(['auth'])->resource('profile', ProfileController::class);

Route::prefix('api')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:api', 'isAdmin'])->group(function() {
        Route::get('/user', [UserControllerAPI::class, 'index']);
        Route::get('/user/all', [UserControllerAPI::class, 'getAll']);
        Route::post('/user', [UserControllerAPI::class, 'createUser']);
        Route::put('/user/{id}', [UserControllerAPI::class, 'updateUser']);
        Route::delete('/user/{id}', [UserControllerAPI::class, 'deleteUser']);
    });
});