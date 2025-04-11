<?php

namespace App\Services\Interfaces;

use App\DTOs\AuthDTO;
use Illuminate\Contracts\Auth\Authenticatable;
interface AuthServiceInterface
{
    public function login(AuthDTO $authDTO): string;
    public function logout(): void;

    public function register(array $data);
    public function refreshToken(): string;
    public function me(): ?Authenticatable;
}
