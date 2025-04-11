<?php

namespace App\Services;

use App\DTOs\ServiceDTO;
use App\Repositories\ServiceRepository;

class ServiceService
{
    public function __construct(
        private readonly ServiceRepository $repository
    ) {}

    public function create(ServiceDTO $dto, string $pageId): array
    {
        $service = $this->repository->create($dto, $pageId);

        return [
            'id' => $service->id,
            'title' => $service->title,
            'description' => $service->description,
            'price' => $service->price,
            'duration' => $service->duration
        ];
    }

    public function find(string $id): ?array
    {
        $service = $this->repository->find($id);

        if (!$service) {
            return null;
        }

        return [
            'id' => $service->id,
            'title' => $service->title,
            'description' => $service->description,
            'price' => $service->price,
            'duration' => $service->duration
        ];
    }

    public function update(string $id, ServiceDTO $dto): ?array
    {
        $service = $this->repository->find($id);

        if (!$service) {
            return null;
        }

        $service = $this->repository->update($service, $dto);

        return [
            'id' => $service->id,
            'title' => $service->title,
            'description' => $service->description,
            'price' => $service->price,
            'duration' => $service->duration
        ];
    }

    public function delete(string $id): bool
    {
        $service = $this->repository->find($id);

        if (!$service) {
            return false;
        }

        $this->repository->delete($service);

        return true;
    }
} 