<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
    public function create(array $data): Page
    {
        return Page::create($data);
    }

    public function find(string $id): ?Page
    {
        return Page::find($id);
    }

    public function findBySlug(string $slug): ?Page
    {
        return Page::where('slug', $slug)->first();
    }

    public function update(Page $page, array $data): Page
    {
        $page->update($data);
        return $page;
    }

    public function delete(Page $page): void
    {
        $page->delete();
    }
} 