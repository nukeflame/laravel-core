<?php

namespace Nukeflame\LaravelCore;

use Illuminate\Support\ServiceProvider;
use Nukeflame\LaravelCore\Core;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Core::class, fn() => new Core());

        $configFile = __DIR__ . '/../config/core.php';
        if (is_file($configFile)) {
            $this->mergeConfigFrom($configFile, 'core');
        }
    }

    public function boot(): void
    {
        $configFile = __DIR__ . '/../config/core.php';
        if (is_file($configFile)) {
            $this->publishes([
                $configFile => $this->app->configPath('core.php'),
            ], 'core-config');
        }

        $migrationPath = __DIR__ . '/../database/migrations';
        if (is_dir($migrationPath)) {
            $this->loadMigrationsFrom($migrationPath);
        }

        $routesFile = __DIR__ . '/../routes/web.php';
        if (is_file($routesFile)) {
            $this->loadRoutesFrom($routesFile);
        }

        $viewsPath = __DIR__ . '/../resources/views';
        if (is_dir($viewsPath)) {
            $this->loadViewsFrom($viewsPath, 'core');
        }
    }
}
