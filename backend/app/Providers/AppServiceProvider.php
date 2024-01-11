<?php

namespace App\Providers;

use App\Repositories\ResultRepository;
use App\Repositories\ResultRepositoryContract;
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
        $this->app->bind(ResultRepositoryContract::class, ResultRepository::class);
    }
}
