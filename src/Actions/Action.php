<?php

namespace MadWeb\Initializer\Actions;

use Exception;
use Illuminate\Console\Command;

abstract class Action
{
    protected const LOADING_TEXT = 'running';

    /** @var \Illuminate\Console\Command */
    private $artisanCommnad;

    private $failed = false;

    protected $errorMessage = null;

    public function __construct(Command $artisanCommnad)
    {
        $this->artisanCommnad = $artisanCommnad;
    }

    public function __invoke(): bool
    {
        $failed = ! $this->getArtisanCommnad()->task($this->title(), function () {
            try {
                return $this->run();
            } catch (Exception $e) {
                $this->errorMessage = get_class($e).': '.$e->getMessage();

                return false;
            }
        }, static::LOADING_TEXT.'...');

        $this->failed = $failed;

        return ! $failed;
    }

    public function failed(): bool
    {
        return $this->failed;
    }

    public function errorMessage():? string
    {
        return $this->errorMessage;
    }

    abstract public function title(): string;

    abstract public function run(): bool;

    public function getArtisanCommnad(): Command
    {
        return $this->artisanCommnad;
    }
}
