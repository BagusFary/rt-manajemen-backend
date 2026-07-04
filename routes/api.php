<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RumahController;
use App\Http\Controllers\Api\KeuanganController;
use App\Http\Controllers\Api\PenghuniController;


Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('penghuni', PenghuniController::class);

    Route::controller(RumahController::class)->group(function () {
        Route::apiResource('rumah', RumahController::class);
        Route::get('rumah/{id}/pembayaran', 'historyPembayaran');
        Route::post('rumah/{id}/assign', 'assignPenghuni');
        Route::post('rumah/{id}/kosongkan', 'kosongkan');
    });

    Route::controller(KeuanganController::class)->prefix('keuangan')->group(function () {
        Route::post('bayar-iuran', 'bayarIuran');
        Route::post('pengeluaran', 'catatPengeluaran');

        Route::get('report/summary-tahunan', 'reportSummaryTahunan');
        Route::get('report/detail-bulanan', 'reportDetailBulanan');
    });

});