<?php

namespace MadWeb\Initializer\Test;

use MadWeb\Initializer\Run;

class OptionRunnerCommandTest extends RunnerCommandsTestCase
{
    /**
     * @test
     * @dataProvider initCommandsOptionSet
     */
    public function option_set($command)
    {
        $test = false;

        $this->declareCommands(function (Run $run) use (&$test) {
            $test = $run->getOption('some');
        }, $command);

        $this->assertTrue($test);
    }

    /**
     * @test
     * @dataProvider initCommandsOptionSet
     */
    public function option_wrong($command)
    {
        $test = false;

        $this->declareCommands(function (Run $run) use (&$test) {
            $test = $run->getOption('wrong');
        }, $command);

        $this->assertFalse($test);
    }

    /**
     * @test
     * @dataProvider initCommandsSet
     */
    public function option_not_set($command)
    {
        $test = false;

        $this->declareCommands(function (Run $run) use (&$test) {
            $test = $run->getOption('some');
        }, $command);

        $this->assertFalse($test);
    }
}
