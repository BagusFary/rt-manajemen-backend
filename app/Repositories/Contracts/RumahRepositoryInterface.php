<?php

namespace App\Repositories\Contracts;

interface RumahRepositoryInterface
{
    public function getAllPaginated(int $perPage, ?string $search = null);
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);    
    public function getWithHistory(int $id); 
}