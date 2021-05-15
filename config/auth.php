<?php

declare(strict_types=1);

return [
    'authorization_server' => 'https://auth2.castelnuovo.xyz',
    'client_id' => env('AUTH_ID'),
    'client_secret' => env('AUTH_SECRET'),
    'session_timeout' => 900, // Seconds of inactivity before session expires
    'session_lifetime' => 86400, // Max lifetime of a session
];
