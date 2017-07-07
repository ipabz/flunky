<?php

use Flunky\Console\Command;

class CommandTest extends BaseTestCase
{
    /**
     * @var Flunky\Console\Command
     */
    protected $command;

    /**
     * Initialize
     *
     * @return void
     */
    public function init()
    {
        $this->command = new Command($this->getBasePath());
    }

    /**
     * @test
     */
    public function run_a_valid_command()
    {
        $command = $this->command->run('ls -l');

        $this->assertInstanceOf(Command::class, $command);
    }

    /**
     * @test
     * @expectedException Flunky\Exceptions\CommandException
     */
    public function run_an_invalid_command()
    {
        $command = $this->command->run('lsa123 -l');
    }

    /**
     * @test
     */
    public function run_a_valid_command_and_extract_output()
    {
        $output = $this->command->extract('ls -l');

        $this->assertTrue(is_array($output));
    }

    /**
     * @test
     * @expectedException Flunky\Exceptions\CommandException
     */
    public function run_an_invalid_command_and_extract_output()
    {
        $output = $this->command->extract('lsaa24234 -l');
    }
}
