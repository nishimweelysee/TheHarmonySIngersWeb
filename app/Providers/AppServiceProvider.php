<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

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
        // Register Blade directives for authorization
        Blade::if('permission', function ($permission) {
            return Auth::check() && Auth::user()->hasPermission($permission);
        });

        Blade::if('role', function ($role) {
            return Auth::check() && Auth::user()->hasRole($role);
        });

        Blade::if('anyRole', function ($roles) {
            return Auth::check() && Auth::user()->hasAnyRole(is_array($roles) ? $roles : [$roles]);
        });

        Blade::if('allPermissions', function ($permissions) {
            return Auth::check() && Auth::user()->hasAllPermissions(is_array($permissions) ? $permissions : [$permissions]);
        });

        Blade::if('anyPermission', function ($permissions) {
            return Auth::check() && Auth::user()->hasAnyPermission(is_array($permissions) ? $permissions : [$permissions]);
        });
    }
}