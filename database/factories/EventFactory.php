<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        $randomDateTime = $this->getRandomDateTime();

        $testUserId = User::whereHas('roles', function ($query) {
            $query->where('name', Role::ROLE_PARISH);
        })->inRandomOrder()->value('id');

        return [
            'name' => 'Nazwa mszy: ' . fake()->name,
            'start_at' => $randomDateTime,
            'priest_id' => $testUserId
        ];
    }

    private function getRandomDateTime(): Carbon
    {
        $startDate = now();
        $endDate = now()->endOfMonth()->addMonth();

        // Obliczamy różnicę w sekundach między datami $startDate i $endDate
        $timestampStart = $startDate->timestamp;
        $timestampEnd = $endDate->timestamp;
        $timeDifference = $timestampEnd - $timestampStart;

        // Generujemy losowy timestamp w ramach tej różnicy
        $randomTimestamp = random_int(0, $timeDifference);

        // Tworzymy obiekt Carbon na podstawie wylosowanego timestamp
        $randomDateTime = $startDate->copy()->addSeconds($randomTimestamp);

        // Sprawdzamy czy godzina jest większa lub równa 23 i zmniejszamy o 1, jeśli tak
        if ($randomDateTime->hour >= 23) {
            $randomDateTime->subHour();
        }

        $randomDateTime->minute(0);

        return $randomDateTime;
    }
}
