<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;

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
    });
});
