#Laravel Api Logger
Log all requests in database;

##Publishing Configs
``
php artisan vendor:publish --provider "LaravelApiLogger\Providers\LaravelApiLoggerServiceProvider" --tag="config"
``
##Publishing Migrations
``
php artisan vendor:publish --provider "LaravelApiLogger\Providers\LaravelApiLoggerServiceProvider" --tag="migrations"
``
