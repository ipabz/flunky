<?php

namespace Flunky\Files\Contracts;

interface FileInterface
{
    /**
     * Gets the contents of a file
     * 
     * @return string
     */
    public function getContents();

    /**
     * Absolute file path
     * 
     * @return string
     */
    public function path();

    /**
     * Get the file extension
     * 
     * @return  string
     */
    public function extension();
}