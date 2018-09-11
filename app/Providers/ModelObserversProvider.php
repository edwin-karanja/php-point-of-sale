<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\Quantity;
use App\Observers\ItemObserver;
use App\Observers\QuantityObserver;
use Illuminate\Support\ServiceProvider;

class ModelObserversProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Item::observe(ItemObserver::class);
        Quantity::observe(QuantityObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
