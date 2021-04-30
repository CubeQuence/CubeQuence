<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\AuthDeviceController;
use App\Controllers\ExampleController;
use App\Controllers\GeneralController;
use App\Controllers\UserController;
use CQ\Middleware\AuthMiddleware;
use CQ\Middleware\JsonMiddleware;
use CQ\Middleware\RatelimitMiddleware;

$route->get('/', [GeneralController::class, 'index']);

$middleware->create(['prefix' => '/auth'], function () use ($route, $middleware) {
    $route->get('/request', [AuthController::class, 'request']);
    $route->get('/callback', [AuthController::class, 'callback']);
    $route->get('/logout', [AuthController::class, 'logout']);

    $middleware->create(['middleware' => [JsonMiddleware::class]], function () use ($route) {
        $route->post('/delete', [AuthController::class, 'delete']);
    });

    $route->get('/request/device', [AuthDeviceController::class, 'request']);
    $route->post('/callback/device', [AuthDeviceController::class, 'callback']);
});

$middleware->create(['middleware' => [AuthMiddleware::class]], function () use ($route, $middleware) {
    $route->get('/dashboard', [UserController::class, 'dashboard']);

    $middleware->create(['prefix' => '/example', 'middleware' => [RatelimitMiddleware::class]], function () use ($route, $middleware) {
        $route->get('', [ExampleController::class, 'index']);

        $middleware->create(['middleware' => [JsonMiddleware::class]], function () use ($route) {
            $route->post('', [ExampleController::class, 'create']);
            $route->patch('/{id}', [ExampleController::class, 'update']);
        });

        $route->delete('/{id}', [ExampleController::class, 'delete']);
    });
});
