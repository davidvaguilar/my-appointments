<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ScheduleServiceInterface;
use App\Services\ScheduleService;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ScheduleServiceInterface::class, ScheduleService::class);
    }
}
