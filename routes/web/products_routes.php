<?php

/** Products */
Route::get('/items', 'ItemController@index');

/** Inventory */
Route::get('/inventory', 'InventoryController@index');

/** Categories */
Route::group(['prefix' => 'categories', 'as' => 'category.'], function () {
    Route::get('/', 'CategoryController@index')->name('index');
    Route::post('/', 'CategoryController@store')->name('store');
    Route::get('/{category}', 'CategoryController@edit')->name('edit');
    Route::post('/{category}', 'CategoryController@update')->name('update');
    Route::post('/delete/{category}', 'CategoryController@delete')->name('delete');
});

Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'namespace' => 'Ajax'], function () {

    /** Products ajax calls */
    Route::group(['prefix' => 'items', 'as' => 'items.'], function () {
        Route::get('/', 'ItemController@index')->name('index');
        Route::post('/', 'ItemController@store')->name('store');
        Route::post('/import', 'ItemController@import')->name('import');
        Route::get('/download_sample', 'ItemController@download')->name('download');
        Route::post('/{item}', 'ItemController@update')->name('update');
        Route::delete('/{id}', 'ItemController@delete')->name('delete');
    });

    /** Inventory Ajax Calls */
    Route::group(['prefix' => 'inventory', 'as' => 'inventory'], function () {
        Route::get('/', 'InventoryController@index')->name('index');
        Route::get('/{item}', 'InventoryController@edit')->name('edit');
        Route::post('/{item}/adjust', 'InventoryController@store')->name('store');
    });

    /** Category Ajax Calls */
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/', 'CategoriesController@index')->name('index');
        Route::post('/', 'CategoriesController@store')->name('store');
        Route::patch('/{category}', 'CategoriesController@update')->name('update');
        Route::delete('/{category}', 'CategoriesController@destroy')->name('destroy');
    });
});