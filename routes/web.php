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

    Route::group(['prefix' => 'customers', 'as' => 'customer.', 'namespace' => 'Customer'], function () {
        Route::get('/', 'CustomerController@index');
        Route::get('/{customer}/account', 'CustomerSalesController@index')->name('account');
    });

    /**
     * Suppliers routes
     */
    Route::group(['prefix' => 'suppliers', 'as' => 'supplier.', 'namespace' => 'Supplier'], function () {
        Route::get('/', 'SupplierController@index')->name('index');

        Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax'], function () {
            Route::get('/', 'SupplierController@index')->name('index');
            Route::post('/', 'SupplierController@store')->name('store');
            Route::get('/{supplier}/bankings', 'SupplierBankingController@index')->name('banking.index');
            Route::post('/{supplier}/bankings', 'SupplierBankingController@store')->name('banking.store');
        });

        Route::get('/{supplier}', 'SupplierMetaController@index')->name('meta');
    });

    /**
     * Settings
     */
    Route::group(['prefix' => 'settings', 'as' => 'settings.', 'namespace' => 'Settings'], function () {
        Route::get('/', 'SettingsController@index');

        Route::group(['prefix' => 'change_password', 'as' => 'change_password.'], function () {
            Route::get('/', 'ChangePasswordController@index')->name('index');
            Route::post('/', 'ChangePasswordController@store')->name('store');
        });

        Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', 'ProfileController@index')->name('index');
            Route::post('/', 'ProfileController@store')->name('store');
        });

        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('/', 'RolesController@index')->name('index');
            Route::get('/create', 'RolesController@create')->name('create');
            Route::post('/store', 'RolesController@store')->name('store');
            Route::get('/{role}/assign', 'RolesController@assign')->name('assign');
            Route::post('/{role}/assign', 'RolesController@assignPermissions')->name('assign.perms');
            Route::get('/{role}/edit', 'RolesController@edit')->name('edit');
            Route::post('/{role}/update', 'RolesController@update')->name('update');
        });

        Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
            Route::get('/', 'PermissionsController@index')->name('index');
            Route::get('/create', 'PermissionsController@create')->name('create');
            Route::post('/store', 'PermissionsController@store')->name('store');
            Route::get('/{permission}/edit', 'PermissionsController@edit')->name('edit');
            Route::post('/{permission}/update', 'PermissionsController@update')->name('update');
        });
    });


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
            Route::post('/import', 'ItemController@import')->name('import');
            Route::get('/download_sample', 'ItemController@download')->name('download');
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
         * Supplier ajax calls
         */
        Route::group(['prefix' => 'suppliers', 'as' => 'supplier.', 'middleware' => 'Supplier'], function () {
            Route::get('/', 'SupplierController@index')->name('index');
            Route::post('/', 'SupplierController@store')->name('store');
        });

        /**
         * Sales Ajax calls
         */
        Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
            Route::post('/', 'SalesController@store')->name('store');
        });

        /**
         * Purchases Ajax calls
         */
        Route::group(['prefix' => 'purchases', 'as' => 'purchases.'], function () {
            Route::post('/', 'PurchasesController@store')->name('store');
        });
    });
});
