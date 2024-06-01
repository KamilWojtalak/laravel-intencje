<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Gate::define('view-sign-to-priest-form', function () {

            if (auth()->user()->isFollower() && auth()->user()->hasNotPriestAssigned()) {
                return true;
            }

            return false;
        });
    }
}
