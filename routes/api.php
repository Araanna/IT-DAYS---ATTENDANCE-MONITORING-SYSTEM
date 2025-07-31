<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Models\YearLevel;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/year-levels', function () {
    return YearLevel::all();
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/qr/{id}', [AuthController::class, 'showQr']);

    Route::get('/attendees', [AuthController::class, 'attendeesList']);
    Route::post('/scan/{id}', [AuthController::class, 'scan']); // Manual ID scan
    Route::post('/scan-qr/{id}', [AuthController::class, 'scanQr']); // QR scan
});
