<?php

namespace App\Services\Interfaces;

use App\DTOs\UserDTO;
use App\Models\User;

interface UserServiceInterface
{
    public function create(UserDTO $dto): User;
    public function find(string $id): ?User;
    public function update(string $id, UserDTO $dto): ?User;
    public function delete(string $id): bool;
} 