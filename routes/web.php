<?php

use App\Http\Controllers\Dashboard\FollowersController;
use App\Http\Controllers\Dashboard\Priest\EventsController as PriestEventsController;
use App\Http\Controllers\Dashboard\Followers\EventsController as FollowersEventsController;
use App\Http\Controllers\Dashboard\PriestsController;
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
                Route::get('/', [PriestsController::class, 'index'])
                    ->name('index');

                Route::post('/{follower}', [PriestsController::class, 'accept'])
                    ->name('accept');

                Route::get('/calendar', [PriestsController::class, 'calendar'])
                    ->name('calendar');

                Route::name('events.')
                    ->prefix('/events')
                    ->group(function () {
                        Route::post('/store', [PriestEventsController::class, 'store'])
                            ->name('store');

                        Route::get('/create', [PriestEventsController::class, 'create'])
                            ->name('create');
                    });
            });

        Route::name('follower.')
            ->prefix('/follower')
            ->group(function () {
                Route::get('/', [FollowersController::class, 'index'])
                    ->name('index');

                Route::get('/calendar', [FollowersController::class, 'calendar'])
                    ->name('calendar');

                Route::name('events.')
                    ->prefix('/events')
                    ->group(function () {
                        Route::post('/store', [FollowersEventsController::class, 'store'])
                            ->name('store');

                        Route::get('/create', [FollowersEventsController::class, 'create'])
                            ->name('create');
                    });
            });

    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/test.php';
