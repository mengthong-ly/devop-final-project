<?php

use App\Http\Controllers\Api\AssignmentController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return "Assignment-service OK";
});

Route::apiResource('assignments', AssignmentController::class);