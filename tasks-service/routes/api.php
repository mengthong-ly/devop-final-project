<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskUserController;

Route::get('/', function () {
    return "Task service running";
});

Route::middleware('auth.micro')->group(function () {
    Route::apiResource('tasks', App\Http\Controllers\Api\TaskController::class);

    // Additional task-user management routes
    Route::put('/tasks/{id}/users', [App\Http\Controllers\Api\TaskController::class, 'assignUsers']);
    Route::delete('/tasks/{id}/users', [App\Http\Controllers\Api\TaskController::class, 'removeUser']);

    // Task ↔ User Relationship
    Route::get('/tasks/{id}/users', [TaskUserController::class, 'users']);
    Route::get('/users/{id}/tasks', [TaskUserController::class, 'tasksByUser']);

    Route::post('/tasks/{id}/assign', [TaskUserController::class, 'assign']);
    Route::post('/tasks/{id}/unassign', [TaskUserController::class, 'unassign']);
});
