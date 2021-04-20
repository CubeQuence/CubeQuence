<?php

declare(strict_types=1);

use App\Controllers\UserController;
use CQ\Middleware\RatelimitMiddleware;

$middleware->create(['middleware' => [RatelimitMiddleware::class]], static function () use ($route): void {
    $route->get('/debug/?{param?}', [UserController::class, 'debug']);
});

// $route->get('/', [General::class, 'index']);
// $route->get('/error/{code}', [General::class, 'error']);

// $middleware->create(['prefix' => '/auth'], function () use ($route) {
//     $route->get('/request', [AuthController::class, 'request']);
//     $route->get('/callback', [AuthController::class, 'callback']);

//     $route->get('/request/device', [AuthController::class, 'requestDevice']);
//     $route->post('/callback/device', [AuthController::class, 'callbackDevice']);

//     $route->get('/logout', [AuthController::class, 'logout']);

//     // TODO: move middleware to group https://github.com/miladrahimi/phprouter#middleware
//     $route->post('/delete', [AuthController::class, 'delete'], JsonMiddleware::class);
// });

// $middleware->create(['middleware' => [SessionMiddleware::class]], function () use ($route) {
//     $route->get('/dashboard', [UserController::class, 'dashboard']);
// });

// $middleware->create(['prefix' => '/example', 'middleware' => [RatelimitMiddleware::class]], function () use ($route) {
//     $route->get('', [ExampleController::class, 'index']);

//     // TODO: move middleware to group https://github.com/miladrahimi/phprouter#middleware
//     $route->post('', [ExampleController::class, 'create'], JsonMiddleware::class);
//     $route->patch('/{id}', [ExampleController::class, 'update'], JsonMiddleware::class);

//     $route->delete('/{id}', [ExampleController::class, 'delete']);
// });
