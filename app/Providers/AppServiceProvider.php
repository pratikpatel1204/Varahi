<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware as MiddlewarePermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware as MiddlewareRoleMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        Route::aliasMiddleware('role', MiddlewareRoleMiddleware::class);
        Route::aliasMiddleware('permission', MiddlewarePermissionMiddleware::class);
        Schema::defaultStringLength(191); // MySQL 5.7 fix
    }
}
