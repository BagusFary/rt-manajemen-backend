<?php

namespace App\Repositories\Eloquent;

use App\Models\Rumah;
use App\Repositories\Contracts\RumahRepositoryInterface;

class RumahRepository implements RumahRepositoryInterface
{
    protected $model;

    public function __construct(Rumah $rumah)
    {
        $this->model = $rumah;
    }

    public function getAllPaginated(int $perPage, ?string $search = null)
    {
        $query = $this->model->with(['riwayatPenghuni' => function ($query) {
            $query->whereNull('tanggal_keluar')->with('penghuni');
        }])->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nomor_rumah', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function getById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $rumah = $this->getById($id);
        $rumah->update($data);
        
        return $rumah;
    }

    public function delete(int $id)
    {
        $rumah = $this->getById($id);
        return $rumah->delete();
    }

    public function getWithHistory(int $id)
    {
        return $this->model->with(['riwayatPenghuni.penghuni'])->findOrFail($id);
    }
}