<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;

Route::get('/', function () {
    return response()->json(['message' => 'Auth Service API after done with command new']);
});

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/validate', [AuthenticationController::class, 'validateToken']);
Route::post('/refresh', [AuthenticationController::class, 'refresh']);


// Optional: registration proxied to Users-Service
Route::post('/register', [AuthenticationController::class, 'register']);
