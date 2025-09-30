<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MealApiController;
use App\Http\Controllers\Api\OrderApiController;

// Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Meals
    Route::get('/meals', [MealApiController::class, 'index']);
    Route::get('/meals/{id}', [MealApiController::class, 'show']);

    // Orders
    Route::get('/orders/{id}', [OrderApiController::class, 'show']);
    Route::post('/checkout', [OrderApiController::class, 'checkout']);
});
