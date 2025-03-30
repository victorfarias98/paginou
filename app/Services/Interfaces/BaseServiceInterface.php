<?php

namespace App\Services\Interfaces;
use App\DTOs\BaseDTO;

interface BaseServiceInterface
{
    public function all();
    public function find(int $id);
    public function create(BaseDTO $dto);
    public function update(int $id, BaseDTO $dto);
    public function delete(int $id);
    public function paginate(int $perPage = 15);
} 