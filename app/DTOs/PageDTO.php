<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class PageDTO
{
    public function __construct(
        public readonly string $userId,
        public readonly string $title,
        public readonly string $description,
        public readonly string $status,
        public readonly ?UploadedFile $thumbnail = null,
    ) {
    }
} 