<?php

namespace App\Services\Interfaces;

use App\DTOs\ServiceDTO;
use App\Models\Service;

interface ServiceServiceInterface
{
    public function create(ServiceDTO $dto): Service;
    public function find(string $id): ?Service;
    public function update(string $id, ServiceDTO $dto): ?Service;
    public function delete(string $id): bool;
} 