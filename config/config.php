<?php

// TODO: load files from /config and add to array

use lucacastelnuovo\Helpers\Arr;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

function config($key, $fallback = null)
{
    static $config;

    if (is_null($config)) {
        $config = [
            'analytics' => [
                'enabled' => true,
                'domainId' => '751563b2-769f-441f-bfab-b3f2c099ccc8',
                'options' => '{ "localhost": false, "detailed": true }'
            ],
            'app' => [
                'url' => env('APP_URL'),
                'id' => env('APP_ID'),
                'variants' => [ // TODO: implement variant checks
                    'Free' => [
                        'monthly_requests' => 200,
                        'max_templates' => 2
                    ],
                    'Personal' => [
                        'monthly_requests' => 1000,
                        'max_templates' => 5
                    ],
                    'Professional' => [
                        'monthly_requests' => 5000,
                        'max_templates' => 100
                    ],
                ],
            ],
            'cors' => [
                'allow_origins' => ['*'],
                'allow_headers' => ['Authorization', 'Content-Type'],
                'allow_methods' => ['HEAD', 'GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS']
            ],
            'database' => [
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => env('DB_DATABASE'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD')
            ],
            'jwt' => [
                'algorithm' => 'HS256',
                'secret' => env('APP_KEY'),
                'iss' => env('APP_URL'),
                'submission' => 31536000 // 1year
            ],
            'smtp' => [
                'host' => env('SMTP_HOST'),
                'port' => env('SMTP_PORT'),
                'username' => env('SMTP_USER'),
                'password' => env('SMTP_PASSWORD'),
                'fromName' => 'Luca Castelnuovo'
            ]
        ];
    }

    return Arr::get($config, $key, $fallback);
}
