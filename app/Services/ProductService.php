<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\MediaService;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly MediaService $mediaService,
    ) {
    }

    public function create(ProductDTO $dto): Product
    {
        $product = $this->productRepository->create([
            'page_id' => $dto->pageId,
            'name' => $dto->name,
            'description' => $dto->description,
            'price' => $dto->price,
            'status' => $dto->status,
        ]);

        if ($dto->image) {
            $this->mediaService->upload(new \App\DTOs\MediaDTO(
                file: $dto->image,
                type: 'image',
                mediableType: Product::class,
                mediableId: $product->id,
            ));
        }

        return $product;
    }

    public function find(string $id): ?array
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            return null;
        }

        return [
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image
        ];
    }

    public function update(Product $product, ProductDTO $dto): Product
    {
        $product = $this->productRepository->update($product, [
            'name' => $dto->name,
            'description' => $dto->description,
            'price' => $dto->price,
            'status' => $dto->status,
        ]);

        if ($dto->image) {
            // Remove a imagem antiga se existir
            $product->media()->delete();
            
            // Upload da nova imagem
            $this->mediaService->upload(new \App\DTOs\MediaDTO(
                file: $dto->image,
                type: 'image',
                mediableType: Product::class,
                mediableId: $product->id,
            ));
        }

        return $product;
    }

    public function delete(Product $product): void
    {
        // Remove todas as mídias associadas
        $product->media()->delete();
        
        $this->productRepository->delete($product);
    }
} 