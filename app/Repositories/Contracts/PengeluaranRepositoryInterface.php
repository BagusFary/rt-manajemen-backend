<?php

namespace App\Repositories\Contracts;

interface PengeluaranRepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function getByBulanTahun(int $bulan, int $tahun);
    public function getTotalPengeluaranPerBulan(int $tahun);
}