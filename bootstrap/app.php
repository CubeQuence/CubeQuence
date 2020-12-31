<?php

require_once __DIR__.'/../vendor/autoload.php';

use CQ\Config\Config;
use CQ\DB\DB;
use CQ\Helpers\App;
use CQ\Routing\Router;

session_start();

// Config
$config = new Config(__DIR__);
$config->attach('analytics');
$config->attach('api');
$config->attach('app');
$config->attach('auth'); // auth.castelnuovo.xyz
$config->attach('cache');
$config->attach('cors');
$config->attach('database');
$config->attach('ratelimit');
$config->attach('roles');
$config->attach('secrets');

// Debug Helper
if (App::debug()) {
    ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();
}

// Database
$database = new DB();
$database->connect();

// Router
$router = new Router([
    '404' => '/_errors/404.html',
    '500' => '/_errors/500.html',
]);

require __DIR__.'/../routes/web.php';

return $router;
