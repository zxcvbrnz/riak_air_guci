<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
        URL::defaults(['locale' => app()->getLocale()]);

        Blade::if('id', function () {
            return app()->getLocale() == 'id';
        });

        // Directive @en ... @enend
        Blade::if('en', function () {
            return app()->getLocale() == 'en';
        });
    }
}
