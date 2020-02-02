# Laravel Api Logger

Log all requests in database;

You can install the package via composer:

`composer require khodemobin/laravel_api_logger`

## Publishing Configs

`php artisan vendor:publish --provider "LaravelApiLogger\Providers\LaravelApiLoggerServiceProvider" --tag="config"`

## Publishing Migrations

`php artisan vendor:publish --provider "LaravelApiLogger\Providers\LaravelApiLoggerServiceProvider" --tag="migrations"`
