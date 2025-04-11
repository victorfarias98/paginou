<?php

namespace App\Services\Interfaces;

use App\DTOs\ProductDTO;
use App\Models\Product;

interface ProductServiceInterface
{
    public function create(ProductDTO $dto): Product;
    public function find(string $id): ?Product;
    public function update(string $id, ProductDTO $dto): ?Product;
    public function delete(string $id): bool;
} 