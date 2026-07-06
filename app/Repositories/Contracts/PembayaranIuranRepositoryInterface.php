<?php

namespace App\Repositories\Contracts;

interface PembayaranIuranRepositoryInterface
{
    public function create(array $data);
    public function update(int $id, array $data);
    public function getHistoryByRumah(int $rumahId);
    public function getByBulanTahun(int $bulan, int $tahun);
    public function getTotalPemasukanPerBulan(int $tahun);
    public function updateOrCreate(array $attributes, array $values);
}