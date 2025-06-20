<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CarAvailabilityService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CarAvailabilityService::class, function ($app) {
            return new CarAvailabilityService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
