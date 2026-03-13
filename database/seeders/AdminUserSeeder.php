<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@studyhive.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'username' => 'admin',
                'email' => 'admin@studyhive.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
    }
}
