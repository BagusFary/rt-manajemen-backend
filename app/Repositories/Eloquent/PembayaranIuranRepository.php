<?php

namespace App\Repositories\Eloquent;

use App\Models\PembayaranIuran;
use App\Repositories\Contracts\PembayaranIuranRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PembayaranIuranRepository implements PembayaranIuranRepositoryInterface
{
    protected $model;

    public function __construct(PembayaranIuran $pembayaranIuran)
    {
        $this->model = $pembayaranIuran;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $pembayaran = $this->model->findOrFail($id);
        $pembayaran->update($data);
        return $pembayaran;
    }

    public function getHistoryByRumah(int $rumahId)
    {
        return $this->model->with('penghuni')
                           ->where('rumah_id', $rumahId)
                           ->orderBy('tahun', 'desc')
                           ->orderBy('bulan', 'desc')
                           ->get();
    }

    public function getByBulanTahun(int $bulan, int $tahun)
    {
        return $this->model->with(['rumah', 'penghuni'])
                           ->where('bulan', $bulan)
                           ->where('tahun', $tahun)
                           ->get();
    }

    public function getTotalPemasukanPerBulan(int $tahun)
    {
        return $this->model->select('bulan', DB::raw('SUM(jumlah_bayar) as total'))
                           ->where('tahun', $tahun)
                           ->where('status_pembayaran', 'lunas')
                           ->groupBy('bulan')
                           ->orderBy('bulan')
                           ->pluck('total', 'bulan')
                           ->toArray();
    }
}