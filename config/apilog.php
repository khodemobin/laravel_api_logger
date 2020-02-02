<?php

return [
    'driver' => env('LOGGER_CONNECTION', 'database'),
    'connection' => env('LOGGER_CONNECTION', 'mysql2'),
    'host' => env('LOGGER_HOST', '127.0.0.1'),
    'port' => env('LOGGER_PORT', '3306'),
    'database' => env('LOGGER_DATABASE', 'forge'),
    'username' => env('LOGGER_USERNAME', ''),
    'password' => env('LOGGER_PASSWORD', ''),
    'middleware' => env('LOGGER_MIDDLEWARE', 'auth'),
];
