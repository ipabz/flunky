<?php

namespace Flunky;

use Flunky\Files\File;
use Flunky\Files\FileManager;
use Flunky\Files\Contracts\FileInterface;
use Flunky\Parsers\Contracts\ParserInterface;

class Flunky
{
    /**
     * @var array
     */
    protected $parsers;

    /**
     * @var array
     */
    protected $handlers;

    /**
     * @var array
     */
    protected $processes;

    /**
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $configFile = new File($basePath . 'Flunky.yaml');

        $this->autoDiscover($basePath);

        $config = $this->getConfig($configFile, $this->getParser($configFile));

        $this->setProcesses($basePath, $config);
    }

    /**
     * Do it's job
     *
     * @return void
     */
    public function start()
    {
        foreach ($this->processes as $process) {
            $process->run();
        }
    }

    /**
     * Set processes
     *
     * @param string $basePath
     * @param string $config
     *
     * @return void
     */
    protected function setProcesses($basePath, $config)
    {
        foreach ($this->handlers as $handler) {
            $this->processes[] = new $handler($basePath, $config);
        }
    }

    /**
     * Get parser
     *
     * @param  FileInterface $file
     *
     * @return ParserInterface
     */
    protected function getParser(FileInterface $file)
    {
        $parser = $this->parsers[$file->extension()];

        return new $parser;
    }

    /**
     * Get config
     *
     * @param  FileInterface $file
     * @param  ParserInterface $parser
     *
     * @return array
     */
    protected function getConfig(FileInterface $file, ParserInterface $parser)
    {
        return $parser->parse($file);
    }

    /**
     * Auto discovery of parsers and handlers
     *
     * @param  string $path
     *
     * @return void
     */
    protected function autoDiscover($path)
    {
        $this->loadParsers();

        $this->loadHandlers();
    }

    /**
     * Load parsers
     */
    protected function loadParsers()
    {
        $this->parsers = config('flunky.Parsers');
    }

    /**
     * Load handlers
     */
    protected function loadHandlers()
    {
        $this->handlers = config('flunky.Handlers');
    }
}
