<?php

namespace Flunky\Handlers;

use Flunky\Console\Command;

class Cron extends Handler
{
    /**
     * @var array
     */
    protected $sites;

    /**
     * @var Command
     */
    protected $command;

    /**
     * Cron constructor.
     *
     * @param string $basePath
     * @param array $config
     */
    public function __construct($basePath, array $config)
    {
        parent::__construct($basePath);

        $this->sites = collect($config['sites']);

        $this->command = new Command($basePath);
    }

    /**
     * Create cron jobs
     */
    public function run()
    {
        $this->sites->each(function ($site) {
            $crons = isset($site['cron']) ? $site['cron'] : [];

            $this->insertCrons($crons);
        });
    }

    /**
     * @param array $crons
     */
    protected function insertCrons(array $crons)
    {
        if (count($crons) <= 0) {
            return;
        }

        foreach ($crons as $cron) {
            $job = $cron['schedule'] . " vagrant " . $cron['command'];

            $this->command->run("sudo echo '$job' >> /etc/crontab");
        }
    }
}
