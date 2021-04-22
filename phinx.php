<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use CQ\Helpers\ConfigHelper;

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds',
    ],
    'environments' => [
        'default_environment' => 'development',
        'default_migration_table' => 'cq_log',
        'development' => [
            'adapter' => 'mysql',
            'host' => ConfigHelper::get('database.host'),
            'name' => ConfigHelper::get('database.database'),
            'user' => ConfigHelper::get('database.username'),
            'pass' => ConfigHelper::get('database.password'),
            'port' => ConfigHelper::get('database.port'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'production' => [
            'adapter' => 'mysql',
            'host' => ConfigHelper::get('database.host'),
            'name' => ConfigHelper::get('database.database'),
            'user' => ConfigHelper::get('database.username'),
            'pass' => ConfigHelper::get('database.password'),
            'port' => ConfigHelper::get('database.port'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];
