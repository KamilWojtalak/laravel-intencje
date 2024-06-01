<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->create([
            'name' => 'admin',
            'strength' => '100',
        ]);

        Role::factory()->create([
            'name' => 'parish',
            'strength' => '10',
        ]);

        Role::factory()->create([
            'name' => 'user',
            'strength' => '1',
        ]);

        $this->call([
            PriestSeeder::class,
            FollowerSeeder::class,
            EventSeeder::class
        ]);

        // User::factory()->create([
        //     'name' => 'Admin user',
        //     'email' => 'admin@admin.admin',
        // ]);
    }
}
