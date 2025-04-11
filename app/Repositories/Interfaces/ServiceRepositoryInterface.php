<?php

namespace App\Repositories\Interfaces;

use App\DTOs\ServiceDTO;
use App\Models\Service;

interface ServiceRepositoryInterface
{
    public function create(ServiceDTO $dto): Service;
    public function find(string $id): ?Service;
    public function update(Service $service, ServiceDTO $dto): Service;
    public function delete(Service $service): void;
} 