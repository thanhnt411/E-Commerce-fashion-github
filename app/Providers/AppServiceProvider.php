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
        'Wishlist'
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin', function (User $user) {
            return $user->name == 'Admin';
        });
    }
}
