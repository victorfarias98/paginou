<?php

namespace Tests\Unit\App\Services;

use App\DTOs\AuthDTO;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $authService;
    private AuthRepositoryInterface $authRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authRepository = $this->createMock(AuthRepositoryInterface::class);
        $this->authService = new AuthService($this->authRepository);
    }

    public function test_login_successfully()
    {
        $password = 'password123';
        $email = 'test@example.com';
        // Arrange
        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        $authDTO = new AuthDTO($email, $password);
        $this->authRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($authDTO->email)
            ->willReturn($user);

        // Act
        $token = $this->authService->login($authDTO);

        // Assert
        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }

    public function test_login_throws_exception_when_credentials_are_invalid()
    {
        // Arrange
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Credenciais inválidas.');

        $authDTO = new AuthDTO('test@example.com', 'wrongpassword');

        $this->authRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with('test@example.com')
            ->willReturn(null);

        // Act
        $this->authService->login($authDTO);
    }

    public function test_register_successfully()
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

        $this->authRepository
            ->expects($this->once())
            ->method('createUser')
            ->with($userData)
            ->willReturn($user);

        // Act
        $result = $this->authService->register($userData);

        // Assert
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($userData['name'], $result->name);
        $this->assertEquals($userData['email'], $result->email);
        $this->assertEquals($userData['phone'], $result->phone);
    }

    public function test_me_returns_authenticated_user()
    {
        // Arrange
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act
        $result = $this->authService->me();

        // Assert
        $this->assertNotNull($result);
        $this->assertEquals($user->id, $result->id);
    }

    public function test_me_returns_null_when_not_authenticated()
    {
        // Act
        $result = $this->authService->me();

        // Assert
        $this->assertNull($result);
    }

    public function test_logout_successfully()
    {
        // Arrange
        $user = User::factory()->create();
        
        // Configura o token JWT e faz login
        $token = JWTAuth::fromUser($user);
        JWTAuth::setToken($token);
        auth()->login($user);

        // Act
        $this->authService->logout();

        // Assert
        $this->assertFalse(auth()->check());
    }

    public function test_refresh_token_successfully()
    {
        // Arrange
        $user = User::factory()->create();
        
        // Configura o token JWT e faz login
        $token = JWTAuth::fromUser($user);
        JWTAuth::setToken($token);
        auth()->login($user);

        // Act
        $newToken = $this->authService->refreshToken();

        // Assert
        $this->assertIsString($newToken);
        $this->assertNotEmpty($newToken);
    }
} 