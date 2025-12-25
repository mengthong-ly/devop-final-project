<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Admin\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('login', [AuthenticationController::class, 'login'])->name('login');
Route::post('login', [AuthenticationController::class, 'authenticate'])->name('login.submit');
// Register
Route::get('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('register', [AuthenticationController::class, 'CreateUserWithEmailAndPassword'])->name('register.submit');
// Logout
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

// Admin (protected by API authentication)
Route::prefix('admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->middleware('api.auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('tasks', TaskController::class);
});
Route::post('/admin/tasks/{task}/assign', [TaskController::class, 'assign'])->name('admin.tasks.assign');
Route::post('/admin/tasks/{task}/unassign', [TaskController::class, 'unassign'])->name('admin.tasks.unassign');
