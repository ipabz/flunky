<?php

namespace Flunky\Files;

use League\Flysystem\Filesystem;
use League\Flysystem\MountManager;
use League\Flysystem\Adapter\Local;

class FileManager
{
    /**
     * @var League\Flysystem\MountManager
     */
    protected $manager;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->manager = new MountManager([
            'local' => new Filesystem(new Local($path))
        ]);
    }

    /**
     * List files PHP files
     * 
     * @param  boolean $recursive
     * @return Illuminate\Support\Collection
     */
    public function listPhpFiles($recursive=false)
    {
        return collect($this->manager->listContents('local://', $recursive))->reject(function($file) {
                return $file['type'] === 'dir' or $file['extension'] !== 'php';
            })
            ->map(function($file) {
                return $file['path'];
            });
    }
}