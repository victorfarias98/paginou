<?php

namespace Tests\Unit\App\Models;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes()
    {
        // Arrange
        $user = new User();

        // Assert
        $this->assertEquals(['name', 'email', 'password', 'avatar', 'phone'], $user->getFillable());
    }

    public function test_hidden_attributes()
    {
        // Arrange
        $user = new User();

        // Assert
        $this->assertEquals(['password', 'remember_token'], $user->getHidden());
    }

    public function test_casts_attributes()
    {
        // Arrange
        $user = new User();

        // Assert
        $this->assertEquals([
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ], $user->getCasts());
    }

    public function test_jwt_identifier_returns_key()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $identifier = $user->getJWTIdentifier();

        // Assert
        $this->assertEquals($user->getKey(), $identifier);
    }

    public function test_jwt_custom_claims_returns_empty_array()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $claims = $user->getJWTCustomClaims();

        // Assert
        $this->assertEquals([], $claims);
    }

    public function test_password_is_hashed_when_set()
    {
        // Arrange
        $password = 'password123';
        $user = User::factory()->create(['password' => $password]);

        // Assert
        $this->assertNotEquals($password, $user->password);
        $this->assertTrue(password_verify($password, $user->password));
    }
} 