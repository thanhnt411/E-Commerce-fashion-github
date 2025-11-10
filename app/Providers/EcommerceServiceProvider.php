<?php

namespace App\Providers;

use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class EcommerceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(UserService::class);
        dd(app()->bound(UserService::class));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        dd('EcommerceServiceProvider boot() đang chạy!');
    }
}
