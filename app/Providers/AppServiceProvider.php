<?php

namespace App\Providers;

use App\Repository\BookingRepository;
use App\Repository\interface\BaseBookingRepository;
use App\Repository\interface\BaseMeetingRoomRepository;
use App\Repository\interface\BaseUserRepository;
use App\Repository\MeetingRoomRepository;
use App\Repository\UserRepository;
use App\Repository\interface\BaseAdminRepository;
use App\Repository\AdminRepository;
use App\Repository\CompanyRepository;
use App\Repository\interface\BaseCompanyRepository;
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
        $this->app->bind(BaseMeetingRoomRepository::class, MeetingRoomRepository::class);
        $this->app->bind(BaseBookingRepository::class, BookingRepository::class);
        $this->app->bind(BaseGuestRepository::class, GuestRepository::class);
        $this->app->bind(BaseCompanyRepository::class, CompanyRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
