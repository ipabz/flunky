<?php

namespace Flunky\Handlers;

use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use League\Flysystem\Adapter\Local;

abstract class Handler
{
    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var League\Flysystem\MountManager
     */
    protected $manager;

    /**
     * @param string $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;

        $this->manager = new MountManager([
            'local' => new Filesystem(new Local($this->basePath))
        ]);
    }

    /**
     * Read file
     *
     * @param  string $file
     *
     * @return string
     */
    public function read($file)
    {
        return $this->manager->read('local://' . $file);
    }
}
