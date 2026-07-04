<?php

namespace App\Repositories\Eloquent;

use App\Models\RiwayatPenghuni;
use App\Repositories\Contracts\RiwayatPenghuniRepositoryInterface;

class RiwayatPenghuniRepository implements RiwayatPenghuniRepositoryInterface
{
    protected $model;

    public function __construct(RiwayatPenghuni $riwayatPenghuni)
    {
        $this->model = $riwayatPenghuni;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getActiveByRumahId(int $rumahId)
    {
        return $this->model->where('rumah_id', $rumahId)
                           ->whereNull('tanggal_keluar')
                           ->first();
    }

    public function closeHistory(int $id, string $tanggalKeluar)
    {
        $riwayat = $this->model->findOrFail($id);
        $riwayat->update(['tanggal_keluar' => $tanggalKeluar]);
        
        return $riwayat;
    }
}