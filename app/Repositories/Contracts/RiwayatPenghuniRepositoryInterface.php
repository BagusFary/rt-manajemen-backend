<?php

namespace App\Repositories\Contracts;

interface RiwayatPenghuniRepositoryInterface
{
    public function create(array $data);
    public function getActiveByRumahId(int $rumahId);
    public function closeHistory(int $id, string $tanggalKeluar);
}