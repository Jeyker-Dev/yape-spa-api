<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PaymentMethodController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware(['auth:sanctum'])->group(function () {
       Route::post('logout', [AuthController::class, 'logout']);

       Route::get('categories', [CategoryController::class, 'index']);
       Route::get('categories/{id}', [CategoryController::class, 'show']);
       Route::post('categories', [CategoryController::class, 'store']);
       Route::put('categories/{id}', [CategoryController::class, 'update']);
       Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

        Route::get('availabilities', [AvailabilityController::class, 'index']);
        Route::get('availabilities/{id}', [AvailabilityController::class, 'show']);
        Route::post('availabilities', [AvailabilityController::class, 'store']);
        Route::put('availabilities/{id}', [AvailabilityController::class, 'update']);
        Route::delete('availabilities/{id}', [AvailabilityController::class, 'destroy']);

        Route::get('services', [ServiceController::class, 'index']);
        Route::get('services/{id}', [ServiceController::class, 'show']);
        Route::post('services', [ServiceController::class, 'store']);
        Route::put('services/{id}', [ServiceController::class, 'update']);
        Route::delete('services/{id}', [ServiceController::class, 'destroy']);

        Route::get('payment-methods', [PaymentMethodController::class, 'index']);
        Route::get('payment-methods/{id}', [PaymentMethodController::class, 'show']);
        Route::post('payment-methods', [PaymentMethodController::class, 'store']);
        Route::put('payment-methods/{id}', [PaymentMethodController::class, 'update']);
        Route::delete('payment-methods/{id}', [PaymentMethodController::class, 'destroy']);

        Route::get('appointments', [App\Http\Controllers\AppointmentController::class, 'index']);
        Route::get('appointments/{id}', [App\Http\Controllers\AppointmentController::class, 'show']);
        Route::post('appointments', [App\Http\Controllers\AppointmentController::class, 'store']);
        Route::put('appointments/{id}', [App\Http\Controllers\AppointmentController::class, 'update']);
        Route::delete('appointments/{id}', [App\Http\Controllers\AppointmentController::class, 'destroy']);

        Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index']);
        Route::get('notifications/{id}', [App\Http\Controllers\NotificationController::class, 'show']);
        Route::post('notifications', [App\Http\Controllers\NotificationController::class, 'store']);
        Route::put('notifications/{id}', [App\Http\Controllers\NotificationController::class, 'update']);
        Route::delete('notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy']);
    });
});
