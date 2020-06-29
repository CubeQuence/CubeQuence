<?php

require_once __DIR__.'/vendor/autoload.php';

use CQ\Config\Config;

$config = new Config(__DIR__.'/bootstrap');
$config->attach('database');

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
            'host' => Config::get('database.host'),
            'name' => Config::get('database.database'),
            'user' => Config::get('database.username'),
            'pass' => Config::get('database.password'),
            'port' => Config::get('database.port'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'production' => [
            'adapter' => 'mysql',
            'host' => Config::get('database.host'),
            'name' => Config::get('database.database'),
            'user' => Config::get('database.username'),
            'pass' => Config::get('database.password'),
            'port' => Config::get('database.port'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];
