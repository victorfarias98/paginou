<?php

namespace Tests\Unit\App\Http\Controllers;

use App\DTOs\AuthDTO;
use App\Http\Controllers\AuthController;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    private AuthController $authController;
    private AuthServiceInterface $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = $this->createMock(AuthServiceInterface::class);
        $this->authController = new AuthController($this->authService);
    }
    
    public function test_logout_returns_success_message()
    {
        // Arrange
        $this->authService
            ->expects($this->once())
            ->method('logout');

        // Act
        $response = $this->authController->logout();

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['message' => 'Logout realizado com sucesso.'], $response->getData(true));
    }

    public function test_refresh_returns_new_token()
    {
        // Arrange
        $newToken = 'new-token';
        $this->authService
            ->expects($this->once())
            ->method('refreshToken')
            ->willReturn($newToken);

        // Act
        $response = $this->authController->refresh();

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(['token' => $newToken], $response->getData(true));
    }

    public function test_me_returns_authenticated_user()
    {
        // Arrange
        $user = User::factory()->create();
        $this->authService
            ->expects($this->once())
            ->method('me')
            ->willReturn($user);

        // Act
        $response = $this->authController->me();

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        
        $responseData = $response->getData(true);
        $this->assertArrayHasKey('user', $responseData);
        $this->assertEquals($user->id, $responseData['user']['id']);
        $this->assertEquals($user->name, $responseData['user']['name']);
        $this->assertEquals($user->email, $responseData['user']['email']);
    }

    public function test_register_returns_success_response()
    {
        // Arrange
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'avatar' => \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg'),
            'phone' => '(11) 99999-9999'
        ];

        $user = User::factory()->make($userData);

        $this->authService
            ->expects($this->once())
            ->method('register')
            ->with($userData)
            ->willReturn($user);

        // Act
        $response = $this->authController->register(new RegisterUserRequest($userData));

        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals([
            'message' => 'Usuário registrado com sucesso!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'phone' => $user->phone,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]
        ], $response->getData(true));
    }
} 