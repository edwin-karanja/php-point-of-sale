<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\Quantity;
use App\Models\Setting;
use App\Observers\ItemObserver;
use App\Observers\QuantityObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('layouts.app', function ($view) {
            $view->with('company', Setting::first());
        });

        Item::observe(ItemObserver::class);
        Quantity::observe(QuantityObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
