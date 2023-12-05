<?php

namespace App\Providers;

use App\Repository\AdminRepository\AdminRepository;
use App\Repository\AdminRepository\BaseAdminRepository;
use App\Repository\UserRepository\BaseUserRepository;
use App\Repository\UserRepository\UserRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseUserRepository::class, UserRepository::class);
        $this->app->bind(BaseAdminRepository::class, AdminRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
