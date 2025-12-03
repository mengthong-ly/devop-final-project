<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Task service running";
});

Route::apiResource('tasks', App\Http\Controllers\Api\TaskController::class);
