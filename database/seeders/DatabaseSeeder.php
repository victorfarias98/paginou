<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\User;
use App\Models\Space;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'id'=> '9e70a2a4-aa87-4657-9ee4-741b49db40ce',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'avatar' => 'avatars/default.jpg',
            'phone' => '(11) 99999-9999',
        ]);
    }
}
