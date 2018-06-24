<?php

Route::group(['prefix' => 'suppliers', 'as' => 'supplier.', 'namespace' => 'Supplier'], function () {
    Route::get('/', 'SupplierController@index')->name('index');

    Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax'], function () {
        Route::get('/', 'SupplierController@index')->name('index');
        Route::post('/', 'SupplierController@store')->name('store');
        Route::get('/{supplier}/contacts', 'SupplierContactsController@index')->name('contacts.index');
        Route::post('/{supplier}/contacts', 'SupplierContactsController@store')->name('contacts.store');
    });

    Route::get('/{supplier}/profile', 'SupplierProfileController@index')->name('profile');
});