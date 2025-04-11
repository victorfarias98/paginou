<?php

namespace App\Repositories\Interfaces;

use App\DTOs\ProductDTO;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function create(ProductDTO $dto, string $pageId): Product;
    public function find(string $id): ?Product;
    public function update(Product $product, ProductDTO $dto): Product;
    public function delete(Product $product): void;
} 