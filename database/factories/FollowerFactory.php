<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class FollowerFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => 'Parafia św. ' . fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function follower(): static
    {
        return $this->state(function (array $attributes) {
            return [];
        })->afterCreating(function ($user) {

            $role = Role::where('name', Role::ROLE_USER)->first();

            if ($role) {
                $user->roles()->attach($role);
            }
        });
    }
}
