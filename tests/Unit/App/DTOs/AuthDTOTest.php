<?php

namespace Tests\Unit\App\DTOs;

use App\DTOs\AuthDTO;
use Tests\TestCase;

class AuthDTOTest extends TestCase
{
    public function test_constructor_sets_properties_correctly()
    {
        // Arrange
        $email = 'test@example.com';
        $password = 'password123';

        // Act
        $dto = new AuthDTO($email, $password);

        // Assert
        $this->assertEquals($email, $dto->email);
        $this->assertEquals($password, $dto->password);
    }

    public function test_from_request_creates_dto_correctly()
    {
        // Arrange
        $data = [
            'email' => 'test@example.com',
            'password' => 'password123'
        ];

        // Act
        $dto = AuthDTO::fromRequest($data);

        // Assert
        $this->assertInstanceOf(AuthDTO::class, $dto);
        $this->assertEquals($data['email'], $dto->email);
        $this->assertEquals($data['password'], $dto->password);
    }

    public function test_from_request_throws_exception_when_data_is_invalid()
    {
        // Arrange
        $this->expectException(\ErrorException::class);

        $data = [
            'email' => 'test@example.com'
            // password is missing
        ];

        // Act
        AuthDTO::fromRequest($data);
    }
} 