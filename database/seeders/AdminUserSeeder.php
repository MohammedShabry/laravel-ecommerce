<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // change email
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // change to secure password
                'role' => 'admin',
                'status' => 'active',
                'phone' => '0000000000',
            ]
        );
    }
}
