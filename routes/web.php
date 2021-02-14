<?php

use CQ\Middleware\JSON;
use CQ\Middleware\RateLimit;
use CQ\Middleware\Session;
use CQ\Controllers\General;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\ExampleController;

$route->get('/', [General::class, 'index']);
$route->get('/error/{code}', [General::class, 'error']);

$middleware->create(['prefix' => '/auth'], function () use ($route) {
    $route->get('/request', [AuthController::class, 'request']);
    $route->get('/callback', [AuthController::class, 'callback']);

    $route->get('/request/device', [AuthController::class, 'requestDevice']);
    $route->post('/callback/device', [AuthController::class, 'callbackDevice']);

    $route->get('/logout', [AuthController::class, 'logout']);

    // TODO: move middleware to group https://github.com/miladrahimi/phprouter#middleware
    $route->post('/delete', [AuthController::class, 'delete'], JSON::class);
});

// $middleware->create(['middleware' => [Session::class]], function () use ($route) {
    $route->get('/dashboard/?{id?}', [UserController::class, 'dashboard']);
// });

$middleware->create(['prefix' => '/example', 'middleware' => [RateLimit::class]], function () use ($route) {
    $route->get('', [ExampleController::class, 'index']);

    // TODO: move middleware to group https://github.com/miladrahimi/phprouter#middleware
    $route->post('', [ExampleController::class, 'create'], JSON::class);
    $route->patch('/{id}', [ExampleController::class, 'update'], JSON::class);

    $route->delete('/{id}', [ExampleController::class, 'delete']);
});
