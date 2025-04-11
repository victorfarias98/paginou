<?php

namespace App\Services;

use App\DTOs\AuthDTO;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

readonly class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository
    ) {}

    /**
     * @throws AuthenticationException
     */
    public function login(AuthDTO $authDTO): string
    {
        $user = $this->authRepository->findByEmail($authDTO->email);

        if (!$user || !Hash::check($authDTO->password, $user->password)) {
            throw new AuthenticationException('Credenciais inválidas.');
        }

        auth()->login($user);

        return auth()->tokenById($user->id);
    }

    public function logout(): void
    {
       auth()->invalidate();
       auth()->logout(true);
    }

    public function refreshToken(): string
    {
        return auth()->refresh(true,true);
    }

    public function register(array $data): User
    {
        if (isset($data['avatar'])) {
            $avatar = $data['avatar'];
            $path = $avatar->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        return $this->authRepository->createUser($data);
    }

    public function me(): ?Authenticatable
    {
        return auth()->user();
    }
}
