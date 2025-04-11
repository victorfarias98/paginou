<?php

namespace App\Http\Controllers;

use App\DTOs\ServiceDTO;
use App\Http\Resources\ServiceResource;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use App\Models\Page;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        private readonly ServiceService $service
    ) {}

    public function store(Request $request, Page $page): JsonResponse
    {
        $dto = ServiceDTO::fromRequest($request->all(), $page->id);
        $service = $this->service->create($dto, $page->id);
        
        return response()->json(new ServiceResource($service), 201);
    }

    public function show(Page $page, string $id): JsonResponse
    {
        $service = $this->service->find($id);
        
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }
        
        return response()->json(new ServiceResource($service));
    }

    public function update(Request $request, Page $page, string $id): JsonResponse
    {
        $dto = ServiceDTO::fromRequest($request->all(), $page->id);
        $service = $this->service->update($id, $dto);
        
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }
        
        return response()->json(new ServiceResource($service));
    }

    public function destroy(Page $page, string $id): JsonResponse
    {
        $deleted = $this->service->delete($id);
        
        if (!$deleted) {
            return response()->json(['message' => 'Service not found'], 404);
        }
        
        return response()->json(null, 204);
    }
} 