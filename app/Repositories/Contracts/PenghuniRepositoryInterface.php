<?php

namespace App\Repositories\Contracts;

interface PenghuniRepositoryInterface
{
    public function getAllPaginated(int $perPage, ?string $search = null);
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}