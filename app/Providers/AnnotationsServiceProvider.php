<?php

namespace App\Providers;

use Collective\Annotations\AnnotationsServiceProvider as ServiceProvider;

class AnnotationsServiceProvider extends ServiceProvider
{
    /**
     * The classes to scan for event annotations.
     *
     * @var array
     */
    protected $scanEvents = [];

    /**
     * The classes to scan for route annotations.
     *
     * @var array
     */
    protected $scanRoutes = [
        \App\Http\Controllers\HomeController::class,
        \App\Http\Controllers\DashboardController::class,
        \App\Http\Controllers\ItemController::class,
        \App\Http\Controllers\Ajax\ItemController::class,
        \App\Http\Controllers\ItemSuppliersController::class,
        \App\Http\Controllers\InventoryController::class,
        \App\Http\Controllers\Ajax\InventoryController::class,
        \App\Http\Controllers\CategoryController::class,
        \App\Http\Controllers\Ajax\CategoriesController::class,

    ];

    /**
     * The classes to scan for model annotations.
     *
     * @var array
     */
    protected $scanModels = [
        \App\Models\Item::class
    ];

    /**
     * Determines if we will auto-scan in the local environment.
     *
     * @var bool
     */
    protected $scanWhenLocal = true;

    /**
     * Determines whether or not to automatically scan the controllers
     * directory (App\Http\Controllers) for routes
     *
     * @var bool
     */
    protected $scanControllers = false;

    /**
     * Determines whether or not to automatically scan all namespaced
     * classes for event, route, and model annotations.
     *
     * @var bool
     */
    protected $scanEverything = false;
}
