<?php

use CQ\Routing\Route;
use CQ\Routing\Middleware;
use CQ\Middleware\Session;

Route::$router = $router->get();
Middleware::$router = $router->get();

Route::get('/', 'GeneralController@index');
Route::get('/error/{code}', 'GeneralController@error');

Middleware::create(['prefix' => '/auth'], function () {
    Route::get('/request', 'AuthController@request');
    Route::get('/callback', 'AuthController@callback');
    Route::get('/logout', 'AuthController@logout');
});

Middleware::create(['middleware' => Session::class], function () {
    Route::get('/dashboard', 'UserController@dashboard');
});
