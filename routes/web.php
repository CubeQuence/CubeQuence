<?php

use CQ\Routing\Route;
use CQ\Routing\Router;

$router = new Router([
    '404' => '/',
    '500' => '/',
]);
Route::$router = $router->get();


Route::get('/', 'GeneralController@index');

Route::get('/closure', function () {
    return 'Closure as a controller';
});

function func()
{
    return 'Function as a controller';
}
Route::get('/function', 'func');
