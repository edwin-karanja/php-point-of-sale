<?php

Route::group(['prefix' => 'customers', 'as' => 'customer.', 'namespace' => 'Customer'], function () {
    Route::get('/', 'CustomerController@index');
    Route::get('/{customer}/account', 'CustomerSalesController@index')->name('account');

    Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax'], function () {
        Route::get('/{customer}/purchases', 'CustomerPurchasesController@index');
        Route::post('/{customer}/purchases/{id}', 'CustomerPurchasesController@store');
        Route::get('/{customer}/payments', 'CustomerPaymentsController@index');
        Route::post('/{customer}/payments/{id}', 'CustomerPaymentsController@store');
        Route::get('/{customer}/overview', 'CustomerOverviewController@index');
        Route::get('/{customer}/monthly-purchases', 'ChartsController@monthly');
        Route::get('/{customer}/contacts', 'CustomerContactsController@index');
        Route::post('/{customer}/contacts', 'CustomerContactsController@store');
        Route::patch('/{customer}/contacts/{contact}', 'CustomerContactsController@update');
        Route::delete('/{customer}/contacts/{contact}', 'CustomerContactsController@destroy');
    });
});

Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax'], function () {

    /** Customer ajax calls */
    Route::group(['prefix' => 'customers', 'as' => 'customer.', 'namespace' => 'Customer'], function () {
        Route::get('/', 'CustomerController@index')->name('index');
        Route::post('/', 'CustomerController@store')->name('store');
        Route::patch('/{customer}', 'CustomerController@update')->name('update');
        Route::delete('/{id}', 'CustomerController@destroy')->name('destroy');
    });
});