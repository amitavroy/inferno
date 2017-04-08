<?php

namespace App\Providers;

use App\Repositories\Dashboard\DashboardRepository;
use App\Repositories\Dashboard\EloquentDashboard;
use App\Repositories\Watchdog\EloquentWatchdog;
use App\Repositories\Watchdog\WatchdogRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        $this->app->bind(WatchdogRepository::class, EloquentWatchdog::class);
        $this->app->bind(DashboardRepository::class, EloquentDashboard::class);
    }
}
