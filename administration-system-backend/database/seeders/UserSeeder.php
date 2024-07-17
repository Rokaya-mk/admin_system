<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => 1, // Admin
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user1@email.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => 2, // Admin
        ]);
    }
}
