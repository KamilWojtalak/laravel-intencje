<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriestSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(4)->priest()->create();
    }
}
