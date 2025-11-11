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

        $this->app->bind('payment', function () {
            return new \App\Services\PaymentService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
