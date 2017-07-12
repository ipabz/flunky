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
        $this->loadParsers($path . 'src/Flunky/Parsers');

        $this->loadHandlers($path . 'src/Flunky/Handlers');
    }

    /**
     * Load parsers
     *
     * @param  string $path
     *
     * @return void
     */
    protected function loadParsers($path)
    {
        $fileManager = new FileManager($path);

        $this->parsers = $fileManager->listPhpFiles()
                                     ->mapWithKeys(function ($file) {
                                         $file  = str_replace('.php', '', $file);
                                         $class = "\\Flunky\\Parsers\\$file";

                                         return [(new $class)->getHandledExtension() => $class];
                                     })
                                     ->toArray();
    }

    /**
     * Load handlers
     *
     * @param  string $path
     *
     * @return void
     */
    protected function loadHandlers($path)
    {
        $fileManager = new FileManager($path);

        $this->handlers = $fileManager->listPhpFiles()
                                      ->reject(function ($file) {
                                          return $file === 'Handler.php';
                                      })
                                      ->map(function ($file) {
                                          $file  = str_replace('.php', '', $file);
                                          $class = "\\Flunky\\Handlers\\$file";

                                          return $class;
                                      })
                                      ->toArray();
    }
}
