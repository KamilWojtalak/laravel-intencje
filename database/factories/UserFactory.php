<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function priest(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Parafia św. ' . fake()->words(3, true)
            ];
        })->afterCreating(function ($user) {

            $role = Role::where('name', Role::ROLE_PARISH)->first();

            if ($role) {
                $user->roles()->attach($role);
            }
        });
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
