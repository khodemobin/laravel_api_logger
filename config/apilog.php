<?php

return [
    'driver' => env('LOGGER_DRIVER', 'database'),

    'database' => [
        'connection' => env('LOGGER_CONNECTION', env('DB_CONNECTION')),
    ],

    'file' => [

    ],

    'should_queue' => false

];
