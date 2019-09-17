<?php

namespace MadWeb\Initializer\ExecutorActions;

use Illuminate\Console\Command;

class Callback
{
    private $artisanCommand;

    private $function;

    private $arguments;

    public function __construct(Command $artisanCommand, callable $function, array $arguments = [])
    {
        $this->artisanCommand = $artisanCommand;
        $this->function = $function;
        $this->arguments = $arguments;
    }

    private function title()
    {
        is_callable($this->function, false, $name);

        return '<comment>Calling function:</comment> '.$name;
    }

    public function __invoke(): bool
    {
        return $this->artisanCommand->task($this->title(), function () {
            if ($this->artisanCommand->getOutput()->isVerbose()) {
                $this->artisanCommand->getOutput()->newLine();
            }

            return call_user_func($this->function, ...$this->arguments);
        });
    }
}
