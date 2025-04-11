<?php

namespace App\Http\Controllers;

use App\DTOs\PageDTO;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Services\PageService;
use Illuminate\Http\JsonResponse;
use App\Models\Page;

class PageController extends Controller
{
    public function __construct(
        private readonly PageService $service
    ) {}

    public function store(StorePageRequest $request): JsonResponse
    {
        $dto = new PageDTO(
            userId: $request->user()->id,
            title: $request->input('title'),
            description: $request->input('description'),
            status: $request->input('status'),
            thumbnail: $request->input('thumbnail')
        );

        $page = $this->service->create($dto, $request->user()->id);

        return response()->json(new PageResource($page), 201);
    }

    public function show(string $id): JsonResponse
    {
        $page = $this->service->find($id);

        if (!$page) {
            return response()->json(['message' => 'Página não encontrada'], 404);
        }

        return response()->json(new PageResource($page));
    }

    public function showBySlug(string $slug): JsonResponse
    {
        $page = $this->service->findBySlug($slug);

        if (!$page) {
            return response()->json(['message' => 'Página não encontrada'], 404);
        }

        return response()->json(new PageResource($page));
    }

    public function update(UpdatePageRequest $request, string $id): JsonResponse
    {
        $dto = new PageDTO(
            userId: $request->user()->id,
            title: $request->input('title'),
            description: $request->input('description'),
            status: $request->input('status'),
            thumbnail: $request->input('thumbnail')
        );

        $page = $this->service->update($id, $dto);

        if (!$page) {
            return response()->json(['message' => 'Página não encontrada'], 404);
        }

        return response()->json(new PageResource($page));
    }

    public function destroy(string $id): JsonResponse
    {
        $success = $this->service->delete($id);

        if (!$success) {
            return response()->json(['message' => 'Página não encontrada'], 404);
        }

        return response()->json(null, 204);
    }
} 