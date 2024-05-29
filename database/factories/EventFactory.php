<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        $startDate = now();

        $endDate = now()->endOfMonth()->addMonth();

        $randomDateTime = fake()->dateTimeBetween($startDate, $endDate);

        $testUserId = User::whereHas('roles', function ($query) {
            $query->where('name', Role::ROLE_PARISH);
        })->inRandomOrder()->value('id');

        return [
            'name' => 'Nazwa mszy: ' . fake()->name,
            'start_at' => $randomDateTime,
            'priest_id' => $testUserId
        ];
    }
}
