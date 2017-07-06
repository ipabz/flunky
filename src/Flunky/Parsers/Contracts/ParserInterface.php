<?php

namespace Flunky\Parsers\Contracts;

use Flunky\Files\Contracts\FileInterface;

interface ParserInterface
{
    /**
     * Parses the file specified
     * 
     * @param  FileInterface $file 
     * @return array
     */
    public function parse(FileInterface $file);

    /**
     * Get file extension of the files it can handle
     * 
     * @return string
     */
    public function getHandledExtension();
}