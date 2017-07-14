<?php

namespace Flunky\Handlers;

use Flunky\Console\Command;

class Linker extends Handler
{
    /**
     * @var array
     */
    protected $folders;

    /**
     * @var Command
     */
    protected $command;

    /**
     * Linker constructor.
     *
     * @param string $basePath
     * @param array $config
     */
    public function __construct($basePath, array $config)
    {
        parent::__construct($basePath);

        $this->folders = collect($config['folders']);

        $this->command = new Command($basePath);
    }

    /**
     * Link directories
     *
     * @return void
     */
    public function run()
    {
        $this->folders->each(function ($folder) {
            $fromLocation = str_replace('~', '/vagrant_data', $folder['map']);
            $toLocation   = $folder['to'];
            $temp         = explode('/', $toLocation);
            $www          = '/var/www/html/' . end($temp);

            $this->command->run("sudo rm -rf $toLocation");
            $this->command->run("sudo rm -rf $www");
            $this->command->run("sudo ln -s $fromLocation $toLocation");
            $this->command->run("sudo ln -s $toLocation $www");
        });
    }
}
