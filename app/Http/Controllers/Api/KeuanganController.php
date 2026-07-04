<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\StorePengeluaranRequest;
use App\Services\KeuanganService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    protected $keuanganService;

    public function __construct(KeuanganService $keuanganService)
    {
        $this->keuanganService = $keuanganService;
    }

    public function bayarIuran(StorePembayaranRequest $request): JsonResponse
    {
        $data = $request->validated();
        $pembayaran = $this->keuanganService->bayarIuran($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran iuran berhasil dicatat.',
            'data' => $pembayaran
        ], 201);
    }

    public function catatPengeluaran(StorePengeluaranRequest $request): JsonResponse
    {
        $data = $request->validated();
        $pengeluaran = $this->keuanganService->catatPengeluaran($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengeluaran berhasil dicatat.',
            'data' => $pengeluaran
        ], 201);
    }

    public function reportSummaryTahunan(Request $request): JsonResponse
    {
        $tahun = $request->query('tahun', Carbon::now()->year);
        
        $summary = $this->keuanganService->getSummaryTahunan($tahun);

        return response()->json([
            'status' => 'success',
            'message' => "Report summary tahun $tahun berhasil diambil.",
            'data' => $summary
        ]);
    }

    public function reportDetailBulanan(Request $request): JsonResponse
    {
        $bulan = $request->query('bulan', Carbon::now()->month);
        $tahun = $request->query('tahun', Carbon::now()->year);

        $detail = $this->keuanganService->getDetailBulanan($bulan, $tahun);

        return response()->json([
            'status' => 'success',
            'message' => "Report detail bulan $bulan tahun $tahun berhasil diambil.",
            'data' => $detail
        ]);
    }
}