<?php

use CQ\Routing\Route;
use CQ\Routing\Middleware;
use CQ\Middleware\CORS;
use CQ\Middleware\JSON;
use CQ\Middleware\Session;
use CQ\Middleware\RateLimit;

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

Middleware::create(['prefix' => '/demo', 'middleware' => [CORS::class, RateLimit::class]], function () {
    Route::get('/', 'DemoController@index');
    Route::post('/', 'DemoController@create', JSON::class);
    Route::patch('/{id}', 'DemoController@update', JSON::class);
    Route::delete('/{id}', 'DemoController@delete');
});
