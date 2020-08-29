<?php

return [
    'id' => env('AUTH_ID'),
    'secret' => env('AUTH_SECRET'),
    'session_timeout' => 900, // Number of seconds of user inactivity before session expires
    'session_lifetime' => 86400, // Max lifetime of a session
    'ip_check' => true, // Validate user IP didn't change
];
