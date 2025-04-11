<?php

namespace App\Http\Controllers;

use App\DTOs\ProductDTO;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $service
    ) {}

    public function create(Page $page)
    {
        return Inertia::render('Pages/CreateProduct', [
            'page' => $page
        ]);
    }

    public function store(Request $request, Page $page): JsonResponse
    {
        $dto = ProductDTO::fromRequest($request->all(), $page->id);
        $product = $this->service->create($dto, $page->id);
        
        return response()->json(new ProductResource($product), 201);
    }

    public function edit(Page $page, Product $product)
    {
        return Inertia::render('Pages/EditProduct', [
            'page' => $page,
            'product' => $product
        ]);
    }

    public function update(Request $request, Page $page, string $id): JsonResponse
    {
        $dto = ProductDTO::fromRequest($request->all(), $page->id);
        $product = $this->service->update($id, $dto);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return response()->json(new ProductResource($product));
    }

    public function destroy(Page $page, string $id): JsonResponse
    {
        $deleted = $this->service->delete($id);
        
        if (!$deleted) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return response()->json(null, 204);
    }

    public function show(Page $page, string $id): JsonResponse
    {
        $product = $this->service->find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return response()->json(new ProductResource($product));
    }
} 