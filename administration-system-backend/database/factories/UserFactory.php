<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
            'role_id' => 2, // default role
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 1, // Admin role_id
            ];
        });
    }

    public function user()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 2, // User role_id
            ];
        });
    }
}
