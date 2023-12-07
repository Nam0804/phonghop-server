<?php

namespace App\Providers;

use App\Repository\interface\BaseUserRepository;
use App\Repository\UserRepository;
use App\Repository\interface\BaseAdminRepository;
use App\Repository\AdminRepository;
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
