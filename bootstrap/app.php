<?php

require_once __DIR__.'/../vendor/autoload.php';

use CQ\DB\DB;
use CQ\Helpers\App;
use CQ\Config\Config;
use CQ\Routing\Router;

session_start();

// Router
$router = new Router(route_404: '/error/404', route_500: '/error/500');
$route = $router->getRoute();
$middleware = $router->getMiddleware();

// Setup global providers
new Config();
new DB();

// Debug Helper
if (App::debug()) {
    ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}

require __DIR__.'/../routes/web.php';

return $router;
