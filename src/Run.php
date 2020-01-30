<?php

namespace MadWeb\Initializer;

use Illuminate\Console\Command;
use MadWeb\Initializer\Actions\Action;
use MadWeb\Initializer\Actions\Artisan;
use MadWeb\Initializer\Actions\Callback;
use MadWeb\Initializer\Actions\Dispatch;
use MadWeb\Initializer\Actions\External;
use MadWeb\Initializer\Actions\Publish;
use MadWeb\Initializer\Actions\PublishTag;
use MadWeb\Initializer\Contracts\Runner as RunnerContract;

class Run implements RunnerContract
{
    protected $artisanCommand;

    protected $options;

    private $errorMessages = [];

    public function __construct(Command $artisanCommand)
    {
        $this->artisanCommand = $artisanCommand;
        $this->options = $artisanCommand->option('options');
    }

    public function errorMessages(): array
    {
        return $this->errorMessages;
    }

    private function run(Action $action)
    {
        $action();

        if ($action->failed()) {
            $this->errorMessages[] = $action->errorMessage();
        }

        return $this;
    }

    public function doneWithErrors(): bool
    {
        return ! empty($this->errorMessages);
    }

    public function artisan(string $command, array $arguments = []): RunnerContract
    {
        return $this->run(new Artisan($this->artisanCommand, $command, $arguments));
    }

    public function publish($providers, bool $force = false): RunnerContract
    {
        return $this->run(new Publish($this->artisanCommand, $providers, $force));
    }

    public function publishForce($providers): RunnerContract
    {
        return $this->publish($providers, true);
    }

    public function publishTag($tag, bool $force = false): RunnerContract
    {
        return $this->run(new PublishTag($this->artisanCommand, $tag, $force));
    }

    public function publishTagForce($tag): RunnerContract
    {
        return $this->publishTag($tag, true);
    }

    public function external(string $command, ...$arguments): RunnerContract
    {
        return $this->run(new External($this->artisanCommand, $command, $arguments));
    }

    public function callable(callable $function, ...$arguments): RunnerContract
    {
        return $this->run(new Callback($this->artisanCommand, $function, $arguments));
    }

    public function dispatch($job): RunnerContract
    {
        return $this->run(new Dispatch($this->artisanCommand, $job));
    }

    public function dispatchNow($job): RunnerContract
    {
        return $this->run(new Dispatch($this->artisanCommand, $job, true));
    }

    public function getOption(string $option): bool
    {
        return in_array($option, $this->options);
    }
}
