<?php

namespace MadWeb\Initializer\Test;

use Closure;
use Illuminate\Support\Facades\Artisan;
use MadWeb\Initializer\Run;

abstract class RunnerCommandsTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind('app.installer', \MadWeb\Initializer\Test\TestFixtures\TestInitializerClass::class);
        $this->app->bind('app.updater', \MadWeb\Initializer\Test\TestFixtures\TestInitializerClass::class);
    }

    protected function declareCommands(Closure $callback, $command, bool $verbose = false): void
    {
        $this->app->resolving(Run::class, function (Run $run) use ($callback) {
            /**
             * @todo Remove this after resolving issue
             * @see https://github.com/laravel/framework/pull/23290
             */
            static $is_called = false;

            $is_called ?: $callback($run);

            $is_called = true;
        });

        putenv('SHELL_VERBOSITY='.($verbose ? 1 : 0));
        Artisan::call($command);
    }

    protected function assertErrorAppeared(string $message, ?string $exception = null)
    {
        $output = Artisan::output();

        self::assertStringContainsString($message, $output);

        if ($exception) {
            self::assertStringContainsString($exception.':', $output);
        }
    }

    public function initCommandsSet()
    {
        return [
            ['app:install'],
            ['app:update'],
        ];
    }

    public function initCommandsOptionSet()
    {
        return [
            ['app:install --options=some'],
            ['app:update --options=some'],
        ];
    }
}
