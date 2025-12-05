<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    protected $services = [
        'Home',
        'Shop',
        'User',
        'Wishlist',
        'Cart',
        'Admin',
    ];

    protected $adminService = [
        'Brand',
        'Category'
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->services as $name) {
            $interface = "App\\Interfaces\\Services\\{$name}ServiceInterface";
            $implement = "App\\Services\\{$name}Service";
            $this->app->bind($interface, $implement);
        }

        foreach ($this->adminService as $name) {
            $interface = "App\\Interfaces\\Services\\Admin\\{$name}ServiceInterface";
            $implement = "App\\Services\\Admin\\{$name}Service";
            $this->app->bind($interface, $implement);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
