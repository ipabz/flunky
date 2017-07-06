<?php

namespace Flunky\Files;

use Flunky\Files\Contracts\FileInterface;

class File implements FileInterface
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @param string $file 
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Gets the contents of a file
     * 
     * @return string
     */
    public function getContents()
    {
        return file_get_contents($this->file);
    }

    /**
     * Absolute file path
     * 
     * @return string
     */
    public function path()
    {
        return $this->file;
    }

    /**
     * Get the file extension
     * 
     * @return  string
     */
    public function extension()
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }
}
