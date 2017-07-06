<?php

namespace Flunky\Handlers;

use Flunky\Console\Command;

class Mysql
{
    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var array
     */
    protected $databases;

    /**
     * @param string $basePath
     * @param array $sites
     */
    public function __construct($basePath, $config)
    {
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
        $this->databases->each(function($database) {
            $command = "bash /vagrant/scripts/create-mysql.sh $database";
            $this->command->run($command);
        });
    }
}
