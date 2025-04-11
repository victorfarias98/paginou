<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MediaDTO
{
    public function __construct(
        public readonly UploadedFile $file,
        public readonly string $type,
        public readonly string $mediableType,
        public readonly int $mediableId,
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        $validator = Validator::make([
            'file' => $this->file,
            'type' => $this->type,
            'mediable_type' => $this->mediableType,
            'mediable_id' => $this->mediableId,
        ], [
            'file' => ['required', 'file', 'max:102400'], // 100MB max
            'type' => ['required', 'string', 'in:image,video,document'],
            'mediable_type' => ['required', 'string'],
            'mediable_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
} 