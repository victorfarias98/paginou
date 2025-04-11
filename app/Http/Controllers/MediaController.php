<?php

namespace App\Http\Controllers;

use App\DTOs\MediaDTO;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    public function __construct(
        private readonly MediaService $mediaService
    ) {
    }

    public function store(Request $request): Response
    {
        $dto = new MediaDTO(
            file: $request->file('file'),
            type: $request->input('type'),
            mediableType: $request->input('mediable_type'),
            mediableId: $request->input('mediable_id'),
        );

        $media = $this->mediaService->upload($dto);

        return response($media, 201);
    }

    public function destroy(Media $media): Response
    {
        $this->mediaService->delete($media);

        return response()->noContent();
    }
} 