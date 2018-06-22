<?php


Route::group(['namespace' => 'Api'], function () {
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login', 'AuthController@login');
    Route::get('auth/user', 'AuthController@user');

    Route::get('products', 'ItemsController@index');
});


