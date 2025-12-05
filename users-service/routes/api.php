<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::post('/user-by-email', [UserController::class, 'UserByEmail']);

// Allow user creation without authentication
Route::post('users', [UserController::class, 'store']);

Route::middleware('auth.micro')->group(function () {
    // Protect other user operations
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
});
