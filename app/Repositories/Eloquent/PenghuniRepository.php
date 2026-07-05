<?php

namespace App\Repositories\Eloquent;

use App\Models\Penghuni;
use App\Repositories\Contracts\PenghuniRepositoryInterface;

class PenghuniRepository implements PenghuniRepositoryInterface
{
    protected $model;

    public function __construct(Penghuni $penghuni)
    {
        $this->model = $penghuni;
    }

    public function getAllPaginated(int $perPage, ?string $search = null)
    {
        $query = $this->model->latest();

        if ($search) {
            $query->where('nama_lengkap', 'like', "%{$search}%");
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
        $penghuni = $this->getById($id);
        $penghuni->update($data);
        
        return $penghuni;
    }

    public function delete(int $id)
    {
        $penghuni = $this->getById($id);
        return $penghuni->delete();
    }
}