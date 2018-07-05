<?php

namespace App\Providers;

use App\Helpers\Breadcrumbs\Breadcrumbs;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        Request::macro('breadcrumbs', function () {
            return new Breadcrumbs( $this );
        });

        Schema::defaultStringLength(191);

        View::composer('layouts.app', function ($view) {
            $view->with('company', Setting::first());
        });

        View::composer('items._layout', function ($view) {
            $view->with('item', request('item'));
        });
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
