<?php

use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::name('test.')
    ->prefix('/test')
    ->group(function () {
        Route::name('users.')
            ->prefix('/users')
            ->group(function () {
                Route::get('/', function () {
                    $users = User::all();

                    return view('test.users.index', compact('users'));
                })
                    ->name('index');

                Route::get('/{user}', function (User $user) {
                    Auth::loginUsingId($user->id);

                    return redirect('/');
                })
                    ->name('store');
            });

        Route::name('orders.')
            ->prefix('/orders')
            ->group(function () {
                Route::get('/', function () {
                    $orders = EventParticipant::get();

                    return view('test.orders.index', compact('orders'));
                })
                    ->name('index');
            });
    });
