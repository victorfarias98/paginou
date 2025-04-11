<?php

namespace Tests\Unit\App\Http\Resources;

use Tests\TestCase;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserResourceTest extends TestCase
{
    public function test_to_array_returns_correct_data()
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'avatar' => 'avatars/test.jpg',
            'phone' => '(11) 99999-9999'
        ]);

        $resource = new UserResource($user);

        // Act
        $data = $resource->toArray(new \Illuminate\Http\Request());

        // Assert
        $this->assertEquals([
            'id' => $user->id,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'avatar' => 'avatars/test.jpg',
            'phone' => '(11) 99999-9999',
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ], $data);
    }
} 