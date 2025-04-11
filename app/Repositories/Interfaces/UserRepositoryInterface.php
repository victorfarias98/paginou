<?php

namespace App\Repositories\Interfaces;

use App\DTOs\UserDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(UserDTO $dto): User;
    public function find(string $id): ?User;
    public function update(User $user, UserDTO $dto): User;
    public function delete(User $user): void;
} 