<?php

namespace App\Providers;

use App\View\Components\Dashboard\DashboardCard;
use App\View\Components\TshirtImage\TshirtImageCard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;


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
        Blade::component('tshirtImage-card', TshirtImageCard::class);
        Blade::component('dashboard-card', DashboardCard::class);
        // for Bootstrap version 4
        //Paginator::useBootstrapFour();
    }
}

