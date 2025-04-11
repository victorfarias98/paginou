<?php

namespace App\Services;

use App\DTOs\MediaDTO;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    public function upload(MediaDTO $dto): Media
    {
        $file = $dto->file;
        $filename = $this->generateFilename($file);
        $path = $this->getStoragePath($dto->type);

        Storage::putFileAs($path, $file, $filename);

        return Media::create([
            'filename' => $filename,
            'original_filename' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
            'type' => $dto->type,
            'mediable_type' => $dto->mediableType,
            'mediable_id' => $dto->mediableId,
        ]);
    }

    public function delete(Media $media): bool
    {
        Storage::delete($media->path . '/' . $media->filename);
        return $media->delete();
    }

    private function generateFilename($file): string
    {
        return Str::uuid() . '.' . $file->getClientOriginalExtension();
    }

    private function getStoragePath(string $type): string
    {
        return match ($type) {
            'image' => 'images',
            'video' => 'videos',
            'document' => 'documents',
            default => 'others',
        };
    }
} 