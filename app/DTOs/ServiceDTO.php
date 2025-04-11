<?php

namespace App\DTOs;

class ServiceDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly float $price,
        public readonly ?string $duration
    ) {}
} 