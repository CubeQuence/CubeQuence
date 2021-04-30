<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CQ\Helpers\AppHelper;
use CQ\Routing\Router;

session_start();

// Router
$router = new Router();
$route = $router->getRoute();
$middleware = $router->getMiddleware();

// Debug Helper
if (AppHelper::isDebug()) {
    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}

require __DIR__ . '/../routes/web.php';

return $router;
