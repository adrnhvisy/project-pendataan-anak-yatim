<?php

use App\Http\Controllers\Api\AnakController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    
    // =========================================================
    // PUBLIC ROUTES (Bisa diakses langsung TANPA LOGIN / TOKEN)
    // =========================================================
    Route::post('/login', [AuthController::class, 'login']);
    
    // Pindahkan rute anak ke sini agar tidak dijaga oleh Sanctum
    Route::get('/anak', [AnakController::class, 'index']);
    Route::get('/anak/{id}', [AnakController::class, 'show']);


    // =========================================================
    // PROTECTED ROUTES (Hanya rute ini yang butuh Token)
    // =========================================================
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});