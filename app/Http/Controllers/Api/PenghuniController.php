<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePenghuniRequest;
use App\Http\Requests\UpdatePenghuniRequest;
use App\Services\PenghuniService;
use Illuminate\Http\JsonResponse;

class PenghuniController extends Controller
{
    protected $penghuniService;

    public function __construct(PenghuniService $penghuniService)
    {
        $this->penghuniService = $penghuniService;
    }

    public function index(): JsonResponse
    {
        $penghuni = $this->penghuniService->getAllPenghuni();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data penghuni berhasil diambil',
            'data' => $penghuni
        ]);
    }

    public function store(StorePenghuniRequest $request): JsonResponse
    {
        $data = $request->validated();
        $fotoKtp = $request->file('foto_ktp');

        $penghuni = $this->penghuniService->createPenghuni($data, $fotoKtp);

        return response()->json([
            'status' => 'success',
            'message' => 'Data penghuni berhasil ditambahkan',
            'data' => $penghuni
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $penghuni = $this->penghuniService->getPenghuniById($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail penghuni berhasil diambil',
            'data' => $penghuni
        ]);
    }

    public function update(UpdatePenghuniRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $fotoKtp = $request->file('foto_ktp');

        $penghuni = $this->penghuniService->updatePenghuni($id, $data, $fotoKtp);

        return response()->json([
            'status' => 'success',
            'message' => 'Data penghuni berhasil diperbarui',
            'data' => $penghuni
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->penghuniService->deletePenghuni($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data penghuni berhasil dihapus'
        ]);
    }
}
