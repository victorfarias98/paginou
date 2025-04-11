<?php

namespace App\Repositories\Interfaces;

use App\DTOs\PageDTO;
use App\Models\Page;

interface PageRepositoryInterface
{
    public function create(PageDTO $dto, string $userId): Page;
    public function find(string $id): ?Page;
    public function findBySlug(string $slug): ?Page;
    public function update(Page $page, PageDTO $dto): Page;
    public function delete(Page $page): void;
} 