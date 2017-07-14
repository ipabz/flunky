<?php

namespace Flunky\Handlers;

use Flunky\Console\Command;

class Mysql extends Handler
{
    /**
     * @var array
     */
    protected $databases;

    /**
     * @var Command
     */
    protected $command;

    /**
     * Mysql constructor.
     *
     * @param string $basePath
     * @param array $config
     */
    public function __construct($basePath, array $config)
    {
        parent::__construct($basePath);

        $this->databases = collect($config['databases']);

        $this->command = new Command($basePath);
    }

    /**
     * Create database
     *
     * @return void
     */
    public function run()
    {
        $this->databases->each(function ($database) {
            $command = "bash /vagrant/scripts/create-mysql.sh $database";
            $this->command->run($command);
        });
    }
}
