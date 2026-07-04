<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RumahController;
use App\Http\Controllers\Api\PenghuniController;


Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('penghuni', PenghuniController::class);

    Route::apiResource('penghuni', PenghuniController::class);
    
    Route::controller(RumahController::class)->group(function () {

        Route::apiResource('rumah', RumahController::class);

        Route::post('rumah/{id}/assign', 'assignPenghuni');
        Route::post('rumah/{id}/kosongkan', 'kosongkan');
    });
    
});