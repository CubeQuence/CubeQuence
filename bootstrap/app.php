<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../database/database.php';
require __DIR__ . '/../routes/web.php';

return $router;
