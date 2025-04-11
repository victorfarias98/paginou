<?php

namespace Tests\Unit\App\Http\Requests;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginUserRequestTest extends TestCase
{
    use RefreshDatabase;

    private LoginUserRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new LoginUserRequest();
    }

    public function test_authorize_returns_true()
    {
        // Act
        $result = $this->request->authorize();

        // Assert
        $this->assertTrue($result);
    }

    public function test_rules_returns_correct_validation_rules()
    {
        // Act
        $rules = $this->request->rules();

        // Assert
        $this->assertEquals([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ], $rules);
    }

    public function test_messages_returns_correct_validation_messages()
    {
        // Act
        $messages = $this->request->messages();

        // Assert
        $this->assertEquals([
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.exists' => 'E-mail ou senha inválidos',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ], $messages);
    }

    public function test_validation_passes_with_valid_data()
    {
        // Arrange
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        // Act
        $validator = $this->app['validator']->make($data, $this->request->rules());

        // Assert
        $this->assertTrue($validator->passes());
    }

    public function test_validation_fails_with_invalid_email()
    {
        // Arrange
        $data = [
            'email' => 'invalid-email',
            'password' => 'password123'
        ];

        // Act
        $validator = $this->app['validator']->make($data, $this->request->rules());

        // Assert
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('email'));
    }

    public function test_validation_fails_with_short_password()
    {
        // Arrange
        $data = [
            'email' => 'test@example.com',
            'password' => '123'
        ];

        // Act
        $validator = $this->app['validator']->make($data, $this->request->rules());

        // Assert
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('password'));
    }

    public function test_validation_fails_with_nonexistent_email()
    {
        // Arrange
        $data = [
            'email' => 'nonexistent@example.com',
            'password' => 'password123'
        ];

        // Act
        $validator = $this->app['validator']->make($data, $this->request->rules());

        // Assert
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('email'));
    }
} 