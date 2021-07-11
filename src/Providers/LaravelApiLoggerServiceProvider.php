<?php

namespace LaravelApiLogger\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;
use LaravelApiLogger\Drivers\Database;
use LaravelApiLogger\Drivers\File;
use LaravelApiLogger\Http\Middleware\ApiLogger;
use LaravelApiLogger\Contracts\ApiLoggerInterface;
use LaravelApiLogger\Console\Commands\GetLogs;
use LaravelApiLogger\Console\Commands\ClearLogs;

class LaravelApiLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws Exception
     */
    public function register(): void
    {
        $this->bindServices();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->commands([
            ClearLogs::class,
            GetLogs::class
        ]);

        $this->publishes([
            __DIR__ . '/../../config/apilog.php' => config_path('apilog.php')
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'apilog');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function bindServices(): void
    {
        $driver = config('apilog.driver');

        $instance = match ($driver) {
            'file' => File::class,
            'database' => Database::class,
            default => throw new \RuntimeException("Unsupported Driver"),
        };

        $this->app->singleton(ApiLoggerInterface::class, $instance);
        $this->app->singleton('apilogger', function ($app) use ($instance) {
            return new ApiLogger($app->make($instance));
        });
    }
}
