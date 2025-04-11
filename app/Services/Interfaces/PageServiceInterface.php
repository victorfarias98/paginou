<?php

namespace App\Services\Interfaces;

use App\DTOs\PageDTO;
use App\Models\Page;

interface PageServiceInterface
{
    public function create(PageDTO $dto, string $userId): Page;
    public function find(string $id): ?Page;
    public function findBySlug(string $slug): ?Page;
    public function update(string $id, PageDTO $dto): ?Page;
    public function delete(string $id): bool;
} 