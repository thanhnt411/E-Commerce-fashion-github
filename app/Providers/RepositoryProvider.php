<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    protected $repositories = [
        'Product',
        'Brand',
        'Category',
        'Order',
        'OrderItem',
        'Transaction'
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $name) {
            $interface = "App\\Interfaces\\Repositories\\{$name}RepositoryInterface";
            $implement = "App\\Repositories\\{$name}Repository";
            $this->app->bind($interface, $implement);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
