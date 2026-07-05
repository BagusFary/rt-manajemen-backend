<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRumahRequest;
use App\Http\Requests\AssignPenghuniRequest;
use App\Services\KeuanganService;
use App\Services\RumahService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class RumahController extends Controller
{
    protected $rumahService;
    protected $keuanganService;

    public function __construct(
        RumahService $rumahService,
        KeuanganService $keuanganService
    )
    {
        $this->rumahService = $rumahService;
        $this->keuanganService = $keuanganService;
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 5);
        $search = $request->query('search', '');

        $rumah = $this->rumahService->getAllRumah($perPage, $search);
        
        return response()->json([
            'status' => 'success', 
            'message' => 'Data rumah berhasil diambil',
            'data' => $rumah
        ]);
    }

    public function store(StoreRumahRequest $request): JsonResponse
    {
        $rumah = $this->rumahService->createRumah($request->validated());
        return response()->json(['status' => 'success', 'data' => $rumah], 201);
    }

    public function show(int $id): JsonResponse
    {
        $rumah = $this->rumahService->getDetailRumah($id);
        return response()->json(['status' => 'success', 'data' => $rumah]);
    }

    public function assignPenghuni(AssignPenghuniRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $riwayat = $this->rumahService->assignPenghuni($id, $data['penghuni_id'], $data['tanggal_masuk']);

        return response()->json([
            'status' => 'success',
            'message' => 'Penghuni berhasil ditetapkan ke rumah ini.',
            'data' => $riwayat
        ]);
    }

    public function kosongkan(Request $request, int $id): JsonResponse
    {
        $tanggalKeluar = $request->input('tanggal_keluar', Carbon::now()->format('Y-m-d'));
        $rumah = $this->rumahService->kosongkanRumah($id, $tanggalKeluar);

        return response()->json([
            'status' => 'success',
            'message' => 'Rumah berhasil dikosongkan dan riwayat ditutup.',
            'data' => $rumah
        ]);
    }

    
    public function historyPembayaran(int $id, KeuanganService $keuanganService): JsonResponse
    {
        $history = $keuanganService->getHistoryPembayaranByRumah($id);

        return response()->json([
            'status' => 'success',
            'message' => 'History pembayaran rumah berhasil diambil.',
            'data' => $history
        ]);
    }
}