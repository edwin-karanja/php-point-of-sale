<?php

Route::group(['prefix' => 'settings', 'as' => 'settings.', 'namespace' => 'Settings'], function () {
    Route::get('/', 'SettingsController@index');

    // Security
    Route::group(['prefix' => 'change_password', 'as' => 'change_password.'], function () {
        Route::get('/', 'ChangePasswordController@index')->name('index');
        Route::post('/', 'ChangePasswordController@store')->name('store');
    });

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', 'ProfileController@index')->name('index');
        Route::post('/', 'ProfileController@store')->name('store');
    });

    // Users
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', 'UsersController@index')->name('index');
        Route::get('/add', 'UsersController@create')->name('create');
        Route::post('/add', 'UsersController@store')->name('store');
        Route::get('/update/{user}', 'UsersController@edit')->name('edit');
        Route::post('/update/{user}', 'UsersController@update')->name('update');
        Route::post('/destroy/{user}', 'UsersController@destroy')->name('destroy');
    });

    // Store settings
    Route::group(['prefix' => 'store', 'as' => 'store.'], function () {
        Route::get('/', 'StoreController@index')->name('index');
        Route::post('/', 'StoreController@store')->name('store');
    });


    if (config('pos.modules.settings.roles_permissions')) {
        // Roles
        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('/', 'RolesController@index')->name('index');
            Route::get('/create', 'RolesController@create')->name('create');
            Route::post('/store', 'RolesController@store')->name('store');
            Route::get('/{role}/assign', 'RolesController@assign')->name('assign');
            Route::post('/{role}/assign', 'RolesController@assignPermissions')->name('assign.perms');
            Route::get('/{role}/edit', 'RolesController@edit')->name('edit');
            Route::post('/{role}/update', 'RolesController@update')->name('update');
        });

        // Permissions
        Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
            Route::get('/', 'PermissionsController@index')->name('index');
            Route::get('/create', 'PermissionsController@create')->name('create');
            Route::post('/store', 'PermissionsController@store')->name('store');
            Route::get('/{permission}/edit', 'PermissionsController@edit')->name('edit');
            Route::post('/{permission}/update', 'PermissionsController@update')->name('update');
        });
    }
});