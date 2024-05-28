<?php

use App\Http\Controllers\Dashboard\FollowerController;
use App\Http\Controllers\Dashboard\PriestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])
    ->name('public.index');

Route::name('dashboard')
    ->get('dashboard', function () {
        $routeName = auth()->user()->getDashboardRouteName();

        return redirect()->route($routeName);
    });

Route::middleware(['auth', 'verified'])
    ->name('dashboard.')
    ->prefix('/dashboard')
    ->group(function () {

        Route::name('priest.')
            ->prefix('/priest')
            ->group(function () {
                Route::get('/', [PriestController::class, 'index'])
                    ->name('index');
            });

        Route::name('follower.')
            ->prefix('/follower')
            ->group(function () {
                Route::get('/', [FollowerController::class, 'index'])
                    ->name('index');
            });

    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/test.php';
