<?php

namespace MadWeb\Initializer;

use Illuminate\Support\ServiceProvider;
use MadWeb\Initializer\Console\Commands\InstallCommand;
use MadWeb\Initializer\Console\Commands\UpdateCommand;
use MadWeb\Initializer\Contracts\Runner;
use NunoMaduro\LaravelConsoleTask\LaravelConsoleTaskServiceProvider;

class InitializerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/initializer.php' => config_path('initializer.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../stubs/install-class.stub' => $this->app['config']['initializer.installer.path'],
            __DIR__.'/../stubs/update-class.stub' => $this->app['config']['initializer.updater.path'],
        ], 'initializers');

        $this->app->register(LaravelConsoleTaskServiceProvider::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UpdateCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/initializer.php', 'initializer');

        $this->app->bind('app.installer', $this->app['config']['initializer.installer.class']);
        $this->app->bind('app.updater', $this->app['config']['initializer.updater.class']);

        $this->app->bind(Runner::class, Run::class);
    }
}
