<?php


Auth::routes();

Route::post('/keep-token-alive', function() {
    return 'hit...'; //https://stackoverflow.com/q/31449434/470749
});

//Route::group(['middleware' => ['auth']], function () {
//
//    if (config('pos.modules.products')) {
//        /** Routes dealing with Products */
//        require_once base_path('routes/web/products_routes.php');
//    }
//
//    if (config('pos.modules.customers')) {
//        /** Routes dealing with Customers */
//        require_once base_path('routes/web/customers_routes.php');
//    }
//
//    if (config('pos.modules.suppliers')) {
//        /** Routes dealing with suppliers */
//        require_once base_path('routes/web/suppliers_routes.php');
//    }
//
//    /** Routes dealing with application settings */
//    require_once base_path('routes/web/settings_routes.php');
//
//    /** Routes dealing with sales and purchases */
//    require_once base_path('routes/web/sales_purchases_routes.php');
//
//    /** Reports */
//    if (config('pos.modules.reports')) {
//        Route::group(['prefix' => 'reports', 'as' => 'reports.', 'namespace' => 'Reports'], function () {
//            Route::get('reports', 'ReportsController@index')->name('index');
//        });
//    }
//
//
//});
