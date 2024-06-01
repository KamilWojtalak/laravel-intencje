<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowerSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(20)->follower()->create();

        $priests = User::whereHas('roles', function (Builder $q) {
            return $q->where('name', Role::ROLE_PARISH);
        })->get();

        $users->each(function ($user) use ($priests) {

            $randomPriest = $priests->random();

            $user->prists()->attach($randomPriest);
        });
    }
}
