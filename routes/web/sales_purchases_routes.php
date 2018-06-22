<?php

if (config('pos.modules.sales')) {
    /** Sales */
    Route::group(['prefix' => 'sales', 'as' => 'sales.', 'namespace' => 'Sales'], function () {
        Route::get('/', 'SalesController@index')->name('index');
        Route::get('/recent', 'SalesController@recent')->name('recent');

        /** Sales Ajax Calls */
        Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax'], function () {

            Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
                Route::post('/', 'SalesController@store')->name('store');
            });
        });
    });
}


if (config('pos.modules.purchases')) {
    /** Purchases */
    Route::group(['prefix' => 'purchases', 'as' => 'purchases.'], function () {
        Route::get('/', 'PurchasesController@index')->name('index');
        Route::get('recent', 'PurchasesController@recent')->name('recent');
    });

    /** Purchases Ajax */
    Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax'], function () {

        Route::group(['prefix' => 'purchases', 'as' => 'purchases.'], function () {
            Route::post('/', 'PurchasesController@store')->name('store');
        });
    });
}
