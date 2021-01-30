<?php

use CQ\Middleware\JSON;
use CQ\Middleware\RateLimit;
use CQ\Middleware\Session;
use CQ\Routing\Middleware;
use CQ\Routing\Route;

Route::$router = $router->get();
Middleware::$router = $router->get();

Route::get('/', 'GeneralController@index');
Route::get('/error/{code}', 'GeneralController@error');

Middleware::create(['prefix' => '/auth'], function () {
    Route::get('/request', 'AuthController@request');
    Route::get('/callback', 'AuthController@callback');

    Route::get('/request/device', 'AuthController@requestDevice');
    Route::post('/callback/device', 'AuthController@callbackDevice');

    Route::get('/logout', 'AuthController@logout');

    Route::post('/delete', 'AuthController@delete', JSON::class);
});

Middleware::create(['middleware' => [Session::class]], function () {
    Route::get('/dashboard', 'UserController@dashboard');
});

Middleware::create(['prefix' => '/example', 'middleware' => [RateLimit::class]], function () {
    Route::get('', 'ExampleController@index');
    Route::post('', 'ExampleController@create', JSON::class);
    Route::patch('/{id}', 'ExampleController@update', JSON::class);
    Route::delete('/{id}', 'ExampleController@delete');
});
