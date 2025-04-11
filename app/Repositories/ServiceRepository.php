<?php

namespace App\Repositories;

use App\Models\Service;
use App\DTOs\ServiceDTO;

class ServiceRepository
{
    public function create(ServiceDTO $dto, string $pageId): Service
    {
        return Service::create([
            'page_id' => $pageId,
            'title' => $dto->title,
            'description' => $dto->description,
            'price' => $dto->price,
            'duration' => $dto->duration
        ]);
    }

    public function find(string $id): ?Service
    {
        return Service::find($id);
    }

    public function update(Service $service, ServiceDTO $dto): Service
    {
        $service->update([
            'title' => $dto->title,
            'description' => $dto->description,
            'price' => $dto->price,
            'duration' => $dto->duration
        ]);

        return $service;
    }

    public function delete(Service $service): void
    {
        $service->delete();
    }
} 