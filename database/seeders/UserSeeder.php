<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin teacher account
        User::create([
            'name' => 'Admin Teacher',
            'email' => 'teacher@quiz.app',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);

        // Create test student account
        User::create([
            'name' => 'Test Student',
            'email' => 'student@quiz.app',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);
    }
}
