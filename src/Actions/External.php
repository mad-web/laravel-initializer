<?php

namespace MadWeb\Initializer\Actions;

use Illuminate\Console\Command;
use RuntimeException;
use Symfony\Component\Process\Process;

class External extends Action
{
    private $command;

    private $arguments;

    public function __construct(Command $artisanCommand, string $command, array $arguments = [])
    {
        parent::__construct($artisanCommand);

        $this->artisanCommand = $artisanCommand;
        $this->command = $command;
        $this->arguments = $arguments;
    }

    public function title(): string
    {
        $argString = implode(' ', $this->arguments);

        return "<comment>Run external command:</comment> $this->command $argString";
    }

    public function run(): bool
    {
        $Process = new Process(empty($this->arguments)
            ? $this->command
            : array_merge([$this->command], $this->arguments));
        $Process->setTimeout(null);

        $isVerbose = $this->artisanCommand->getOutput()->isVerbose();

        if ($isVerbose) {
            $this->artisanCommand->getOutput()->newLine();
            if (Process::isTtySupported()) {
                $Process->setTty(true);
            } elseif (Process::isPtySupported()) {
                $Process->setPty(true);
            }
        }

        $Process->run($isVerbose ? function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->artisanCommand->error($buffer);
            } else {
                $this->artisanCommand->line($buffer);
            }
        } : null);

        $error = empty($Process->getErrorOutput()) ? $Process->getOutput() : $Process->getErrorOutput();
        $exitCode = $Process->getExitCode();

        if ($error and $exitCode > 0) {
            throw new RuntimeException(trim($error));
        }

        return ! $exitCode;
    }
}
