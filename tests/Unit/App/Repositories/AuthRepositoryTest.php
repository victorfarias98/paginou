<?php

namespace Tests\Unit\App\Repositories;

use App\Models\User;
use App\Repositories\AuthRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private AuthRepository $authRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authRepository = new AuthRepository();
    }

    public function test_find_by_email_returns_user_when_exists()
    {
        // Arrange
        $user = User::factory()->create(['email' => 'test@example.com']);

        // Act
        $result = $this->authRepository->findByEmail('test@example.com');

        // Assert
        $this->assertNotNull($result);
        $this->assertEquals($user->id, $result->id);
        $this->assertEquals($user->email, $result->email);
    }

    public function test_find_by_email_returns_null_when_user_not_exists()
    {
        // Act
        $result = $this->authRepository->findByEmail('nonexistent@example.com');

        // Assert
        $this->assertNull($result);
    }

    public function test_create_user_successfully()
    {
        // Arrange
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'avatar' => 'avatars/test.jpg',
            'phone' => '(11) 99999-9999'
        ];

        // Act
        $user = $this->authRepository->createUser($userData);

        // Assert
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['name'], $user->name);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertEquals($userData['avatar'], $user->avatar);
        $this->assertEquals($userData['phone'], $user->phone);
        $this->assertDatabaseHas('users', [
            'email' => $userData['email']
        ]);
    }
} 