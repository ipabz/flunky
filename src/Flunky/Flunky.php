<?php

namespace Flunky;

use Flunky\Files\File;
use Flunky\Handlers\Mysql;
use Flunky\Handlers\Linker;
use Flunky\Parsers\YamlParser;
use Flunky\Handlers\VirtualHost;
use Flunky\Files\Contracts\FileInterface;
use Flunky\Parsers\Contracts\ParserInterface;

class Flunky
{
    /**
     * @var array
     */
    protected $parsers = [
        'yaml' => YamlParser::class
    ];

    /**
     * @var array
     */
    protected $handlers = [
        Linker::class,
        VirtualHost::class,
        Mysql::class
    ];

    /**
     * @var array
     */
    protected $processes = [];

    /**
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $configFile = new File($basePath . 'Flunky.yaml');

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
     * @param  FileInterface   $file   
     * @param  ParserInterface $parser 
     * @return array
     */
    protected function getConfig(FileInterface $file, ParserInterface $parser)
    {
        return $parser->parse($file);
    }
}
