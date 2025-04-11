<?php

namespace Tests\Unit\App\Http\Requests;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserRequestTest extends TestCase
{
    use RefreshDatabase;

    private RegisterUserRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new RegisterUserRequest();
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
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'phone' => ['required', 'string', 'min:10', 'max:15'],
        ], $rules);
    }

    public function test_messages_returns_correct_validation_messages()
    {
        // Act
        $messages = $this->request->messages();

        // Assert
        $this->assertEquals([
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'avatar.required' => 'O avatar é obrigatório.',
            'avatar.image' => 'O arquivo deve ser uma imagem.',
            'avatar.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.',
            'avatar.max' => 'A imagem não pode ter mais de 2MB.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.min' => 'O telefone deve ter pelo menos 10 caracteres.',
            'phone.max' => 'O telefone não pode ter mais de 15 caracteres.',
        ], $messages);
    }

    public function test_validation_passes_with_valid_data()
    {
        // Arrange
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'avatar' => \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg'),
            'phone' => '(11) 99999-9999'
        ];

        // Act
        $validator = $this->app['validator']->make($data, $this->request->rules());

        // Assert
        $this->assertTrue($validator->passes());
    }

    public function test_validation_fails_with_short_name()
    {
        // Arrange
        $data = [
            'name' => 'Te',
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        // Act
        $validator = $this->app['validator']->make($data, $this->request->rules());

        // Assert
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('name'));
    }

    public function test_validation_fails_with_invalid_email()
    {
        // Arrange
        $data = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123'
        ];

        // Act
        $validator = $this->app['validator']->make($data, $this->request->rules());

        // Assert
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('email'));
    }

    public function test_validation_fails_with_duplicate_email()
    {
        // Arrange
        User::factory()->create(['email' => 'test@example.com']);

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
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
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123'
        ];

        // Act
        $validator = $this->app['validator']->make($data, $this->request->rules());

        // Assert
        $this->assertFalse($validator->passes());
        $this->assertTrue($validator->errors()->has('password'));
    }
} 