<?php

namespace MadWeb\Initializer\Contracts;

interface Runner
{
    public function errorMessages(): array;

    public function doneWithErrors(): bool;

    public function artisan(string $command, array $arguments = []): self;

    public function external(string $command, ...$arguments): self;

    public function callable(callable $function, ...$arguments): self;

    public function dispatch($job): self;

    public function dispatchNow($job): self;

    public function publish($providers, bool $force = false): self;

    public function publishForce($providers): self;

    public function publishTag($tag, bool $force = false): self;

    public function publishTagForce($tag): self;

    public function getOption(string $option): bool;
}
