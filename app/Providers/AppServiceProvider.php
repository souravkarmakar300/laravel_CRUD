<?php

namespace App\Providers;

use App\Models\ProductLogin;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('isAdmin', function (ProductLogin $productLogin) {
            return $productLogin->role === 'admin';
        });

        Gate::define('isUser', function (ProductLogin $productLogin) {
            return $productLogin->role === 'user';
        });

        // Gate::define('profile_view', function (ProductLogin $productLogin, $userID) {
        //     return $productLogin->id === $userID;
        // });
    }
}
