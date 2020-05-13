<?php

require_once __DIR__ . '/../vendor/autoload.php';

use CQ\Helpers\App;
use CQ\Config\Config;

session_start();

// Config
$config = new Config(__DIR__);
$config->attach('analytics');
$config->attach('app');
$config->attach('cache');
$config->attach('cors');
$config->attach('database');
$config->attach('variants');

// Debug Helper
if (App::debug()) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

// Database TODO: build db functions
// require __DIR__ . '/../database/database.php';

// Router
require __DIR__ . '/../routes/web.php';

return $router;
