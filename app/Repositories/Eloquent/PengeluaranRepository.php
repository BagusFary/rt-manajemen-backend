<?php

namespace App\Repositories\Eloquent;

use App\Models\Pengeluaran;
use App\Repositories\Contracts\PengeluaranRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PengeluaranRepository implements PengeluaranRepositoryInterface
{
    protected $model;

    public function __construct(Pengeluaran $pengeluaran)
    {
        $this->model = $pengeluaran;
    }

    public function getAll()
    {
        return $this->model->orderBy('tanggal_pengeluaran', 'desc')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $pengeluaran = $this->model->findOrFail($id);
        $pengeluaran->update($data);
        return $pengeluaran;
    }

    public function delete(int $id)
    {
        $pengeluaran = $this->model->findOrFail($id);
        return $pengeluaran->delete();
    }

    public function getByBulanTahun(int $bulan, int $tahun)
    {
        return $this->model->whereMonth('tanggal_pengeluaran', $bulan)
                           ->whereYear('tanggal_pengeluaran', $tahun)
                           ->orderBy('tanggal_pengeluaran', 'desc')
                           ->get();
    }

    public function getTotalPengeluaranPerBulan(int $tahun)
    {
        return $this->model->select(DB::raw('MONTH(tanggal_pengeluaran) as bulan'), DB::raw('SUM(jumlah) as total'))
                           ->whereYear('tanggal_pengeluaran', $tahun)
                           ->groupBy(DB::raw('MONTH(tanggal_pengeluaran)'))
                           ->orderBy('bulan')
                           ->pluck('total', 'bulan')
                           ->toArray();
    }
}