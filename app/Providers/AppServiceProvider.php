<?php

namespace App\Providers;

use App\Services\LibraryHoursService;
use Illuminate\Support\Facades\View;
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
        View::share('libraryStatus', app(LibraryHoursService::class)->current());
    }
}
