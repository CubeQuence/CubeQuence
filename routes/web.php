<?php

use App\Middleware\CORSMiddleware;
use App\Middleware\JSONMiddleware;
use App\Middleware\JWTMiddleware;
use App\Middleware\SessionMiddleware;
use App\Middleware\RateLimitMiddleware;
use MiladRahimi\PhpRouter\Router;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use Zend\Diactoros\Response\RedirectResponse;

$router = new Router('', 'App\Controllers');
$router->define('code', '[0-9]+');

$router->get('/', 'GeneralController@index');
$router->get('/error/{code}', 'GeneralController@error');

$router->group(['prefix' => '/auth'], function (Router $router) {
    $router->get('/request', 'AuthController@request');
    $router->get('/callback', 'AuthController@callback');
    $router->get('/logout', 'AuthController@logout');
});

$router->group(['middleware' => SessionMiddleware::class], function (Router $router) {
    $router->get('/dashboard', 'UserController@dashboard');
    $router->get('/history/{id}', 'UserController@history');
});

$router->group(['prefix' => '/template', 'middleware' => [JSONMiddleware::class, SessionMiddleware::class]], function (Router $router) {
    $router->post('', 'TemplateController@create');
    $router->put('/{id}', 'TemplateController@update');
    $router->delete('/{id}', 'TemplateController@delete');

    $router->post('/{id}/key', 'TemplateController@createKey');
    $router->delete('/{id}/key', 'TemplateController@resetKey');
});

$router->group(['middleware' => [CORSMiddleware::class, RateLimitMiddleware::class, JWTMiddleware::class, JSONMiddleware::class]], function (Router $router) {
    $router->any('/submit', 'SubmissionController@submit');
});

try {
    $router->dispatch();
} catch (RouteNotFoundException $e) {
    $router->getPublisher()->publish(new RedirectResponse('/error/404', 404));
} catch (Throwable $e) {
    $router->getPublisher()->publish(new RedirectResponse("/error/500?e={$e}", 500));
}

// Route::get('/', function () {
//     return view('welcome');
// });
