<?php

namespace App\Services;

use App\Repositories\Contracts\RumahRepositoryInterface;
use App\Repositories\Contracts\RiwayatPenghuniRepositoryInterface;
use Carbon\Carbon;

class RumahService
{
    protected $rumahRepo;
    protected $riwayatRepo;

    public function __construct(
        RumahRepositoryInterface $rumahRepo,
        RiwayatPenghuniRepositoryInterface $riwayatRepo
    ) {
        $this->rumahRepo = $rumahRepo;
        $this->riwayatRepo = $riwayatRepo;
    }

    public function getAllRumah($perPage = 5, $search = null)
    {
        return $this->rumahRepo->getAllPaginated($perPage, $search);
    }

    public function getDetailRumah(int $id)
    {
        return $this->rumahRepo->getWithHistory($id);
    }

    public function createRumah(array $data)
    {
        return $this->rumahRepo->create($data);
    }

    public function updateRumah(int $id, array $data)
    {
        return $this->rumahRepo->update($id, $data);
    }

    public function deleteRumah(int $id)
    {
        return $this->rumahRepo->delete($id);
    }
    
    public function assignPenghuni(int $rumahId, int $penghuniId, string $tanggalMasuk)
    {
        $penghuniAktif = $this->riwayatRepo->getActiveByRumahId($rumahId);

        if ($penghuniAktif) {
            $this->riwayatRepo->closeHistory($penghuniAktif->id, Carbon::now()->format('Y-m-d'));
        }

        $riwayatBaru = $this->riwayatRepo->create([
            'rumah_id' => $rumahId,
            'penghuni_id' => $penghuniId,
            'tanggal_masuk' => $tanggalMasuk,
            'tanggal_keluar' => null,
        ]);

        $this->rumahRepo->update($rumahId, ['status_rumah' => 'dihuni']);

        return $riwayatBaru;
    }

    public function kosongkanRumah(int $rumahId, string $tanggalKeluar)
    {
        $penghuniAktif = $this->riwayatRepo->getActiveByRumahId($rumahId);

        if ($penghuniAktif) {
            $this->riwayatRepo->closeHistory($penghuniAktif->id, $tanggalKeluar);
        }

        return $this->rumahRepo->update($rumahId, ['status_rumah' => 'tidak_dihuni']);
    }
}