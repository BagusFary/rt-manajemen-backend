<?php

namespace App\Services;

use App\Repositories\Contracts\PenghuniRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class PenghuniService
{
    protected $penghuniRepository;

    public function __construct(PenghuniRepositoryInterface $penghuniRepository)
    {
        $this->penghuniRepository = $penghuniRepository;
    }

    public function getAllPenghuni()
    {
        return $this->penghuniRepository->getAll();
    }

    public function getPenghuniById(int $id)
    {
        return $this->penghuniRepository->getById($id);
    }

    public function createPenghuni(array $data, $fotoKtp = null)
    {
        if ($fotoKtp) {
            $path = $fotoKtp->store('ktp', 'public');
            $data['foto_ktp'] = $path;
        }

        return $this->penghuniRepository->create($data);
    }

    public function updatePenghuni(int $id, array $data, $fotoKtp = null)
    {
        $penghuniLama = $this->penghuniRepository->getById($id);

        if ($fotoKtp) {
            if ($penghuniLama->foto_ktp && Storage::disk('public')->exists($penghuniLama->foto_ktp)) {
                Storage::disk('public')->delete($penghuniLama->foto_ktp);
            }
            
            $path = $fotoKtp->store('ktp', 'public');
            $data['foto_ktp'] = $path;
        }

        return $this->penghuniRepository->update($id, $data);
    }

    public function deletePenghuni(int $id)
    {
        $penghuni = $this->penghuniRepository->getById($id);

        if ($penghuni->foto_ktp && Storage::disk('public')->exists($penghuni->foto_ktp)) {
            Storage::disk('public')->delete($penghuni->foto_ktp);
        }

        return $this->penghuniRepository->delete($id);
    }
}