<?php

namespace App\Providers;

use App\Collections\ComponentCollection;
use Illuminate\Support\Collection;
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
        Collection::macro('repack', function () {
            return (new ComponentCollection($this->items))->repack();
        });
    }
}
