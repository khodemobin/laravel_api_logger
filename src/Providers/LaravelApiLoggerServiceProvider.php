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
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/apilog.php',
            'apilog'
        );
        $this->bindServices();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadConfig();
        $this->loadRoutes();
        $this->loadViews();
        $this->loadCommand();
        $this->loadMigrations();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/apilog.php' => config_path('apilog.php'),
            ], 'config');
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/' => database_path('migrations'),
            ], 'migrations');
        }
    }

    public function bindServices(): void
    {
        $driver = config('apilog.driver');
        switch ($driver) {
            case 'file':
                $instance = File::class;
                break;
            case 'database':
                $instance = Database::class;
                break;
            default:
                throw new \RuntimeException("Unsupported Driver");
                break;
        }

        $this->app->singleton(ApiLoggerInterface::class, $instance);
        $this->app->singleton('apilogger', function ($app) use ($instance) {
            return new ApiLogger($app->make($instance));
        });
    }


    public function loadConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/apilog.php' => config_path('apilog.php')
        ], 'config');
    }


    public function loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }

    public function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'apilog');
    }

    public function loadCommand(): void
    {
        $this->commands([
            ClearLogs::class,
            GetLogs::class
        ]);
    }

    public function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
