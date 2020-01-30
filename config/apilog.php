<?php

return [
    'driver' => 'database',
    'connection' => env('LOGGER_CONNECTION', 'mysql'),
    'host' => env('LOGGER_HOST', env('DB_HOST', '127.0.0.1')),
    'port' => env('LOGGER_PORT', env('DB_PORT', '3306')),
    'database' => env('LOGGER_DATABASE', env('DB_DATABASE', 'forge')),
    'username' => env('LOGGER_USERNAME', env('DB_USERNAME', '')),
    'password' => env('LOGGER_PASSWORD', env('DB_PASSWORD', '')),
];
