<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->get('/users/search', [UserController::class, 'searchByName'])->name('users.searchByName');
Route::middleware(['auth', 'isAdmin'])->resource('users', UserController::class);
Route::middleware(['auth'])->resource('profile', ProfileController::class);