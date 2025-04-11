<?php

namespace App\Services;

use App\DTOs\PageDTO;
use App\Repositories\PageRepository;
use App\Models\Page;
use App\Services\MediaService;
use Illuminate\Http\UploadedFile;

class PageService
{
    public function __construct(
        private readonly PageRepository $pageRepository,
        private readonly MediaService $mediaService,
    ) {
    }

    public function create(PageDTO $dto): Page
    {
        $page = $this->pageRepository->create([
            'user_id' => $dto->userId,
            'title' => $dto->title,
            'description' => $dto->description,
            'status' => $dto->status,
        ]);

        if ($dto->thumbnail) {
            $this->mediaService->upload(new \App\DTOs\MediaDTO(
                file: $dto->thumbnail,
                type: 'image',
                mediableType: Page::class,
                mediableId: $page->id,
            ));
        }

        return $page;
    }

    public function find(string $id): ?Page
    {
        return $this->pageRepository->find($id)->load(['services', 'products']);
    }

    public function findBySlug(string $slug): ?Page
    {
        return $this->pageRepository->findBySlug($slug)->load(['services', 'products']);
    }

    public function update(Page $page, PageDTO $dto): Page
    {
        $page = $this->pageRepository->update($page, [
            'title' => $dto->title,
            'description' => $dto->description,
            'status' => $dto->status,
        ]);

        if ($dto->thumbnail) {
            $page->media()->delete();
            
            $this->mediaService->upload(new \App\DTOs\MediaDTO(
                file: $dto->thumbnail,
                type: 'image',
                mediableType: Page::class,
                mediableId: $page->id,
            ));
        }

        return $page;
    }

    public function delete(Page $page): void
    {
        $page->media()->delete();
        
        $this->pageRepository->delete($page);
    }
} 