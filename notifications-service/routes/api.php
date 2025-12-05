<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;


Route::get('/', function () {
    return response()->json(['message' => 'Notifications Service API']);
});

Route::middleware('auth.micro')->group(function () {
    Route::apiResource('notifications', NotificationController::class);
    Route::post('notifications/markAsRead/{id}', [NotificationController::class, 'markAsRead']);
    Route::get('getNotificationsUser/{user_id}', [NotificationController::class, 'getNotificationsUser']);
});
