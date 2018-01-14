<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'DashboardController@index');

    /**
     * Categories
     */
    Route::group(['prefix' => 'categories', 'as' => 'category.'], function () {
        Route::get('/', 'CategoryController@index')->name('index');
        Route::post('/', 'CategoryController@store')->name('store');
        Route::get('/{category}', 'CategoryController@edit')->name('edit');
        Route::post('/{category}', 'CategoryController@update')->name('update');
        Route::post('/delete/{category}', 'CategoryController@delete')->name('delete');
    });



    /**
     * Items
     */
    Route::get('/items', 'ItemController@index');

    /**
     * Inventory
     */
    Route::get('/inventory', 'InventoryController@index');

    /**
     * Customers
     */
    Route::get('/customers', 'CustomerController@index');

    /**
     * Suppliers
     */
    Route::get('/suppliers', 'SupplierController@index');

    /**
     * Sales
     */
    Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
        Route::get('/', 'SalesController@index')->name('index');
        Route::get('/recent', 'SalesController@recent')->name('recent');
    });

    /**
     * Purchases
     */
    Route::get('/purchases', 'PurchasesController@index');

    Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax'], function () {
        /**
         * Items ajax calls
         */
        Route::group(['prefix' => 'items', 'as' => 'items.'], function () {
            Route::get('/', 'ItemController@index')->name('index');
            Route::post('/', 'ItemController@store')->name('store');
            Route::post('/{item}', 'ItemController@update')->name('update');
            Route::delete('/{id}', 'ItemController@delete')->name('delete');
        });

        /**
         * Inventory ajax calls
         */
        Route::group(['prefix' => 'inventory', 'as' => 'inventory'], function () {
            Route::get('/', 'InventoryController@index')->name('index');
            Route::get('/{item}', 'InventoryController@edit')->name('edit');
            Route::post('/{item}/adjust', 'InventoryController@store')->name('store');
        });

        /**
         * Customer ajax calls
         */
        Route::group(['prefix' => 'customers', 'as' => 'customer.'], function () {
            Route::get('/', 'CustomerController@index')->name('index');
            Route::post('/', 'CustomerController@store')->name('store');
            Route::patch('/{customer}', 'CustomerController@update')->name('update');
            Route::delete('/{id}', 'CustomerController@destroy')->name('destroy');
        });

        /**
         * Sales Ajax calls
         */
        Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
            Route::post('/', 'SalesController@store')->name('store');
        });
    });
});
