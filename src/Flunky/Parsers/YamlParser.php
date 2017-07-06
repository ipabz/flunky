<?php

namespace Flunky\Parsers;

use Symfony\Component\Yaml\Yaml;
use Flunky\Files\Contracts\FileInterface;
use Flunky\Parsers\Contracts\ParserInterface;

class YamlParser implements ParserInterface
{
    /**
     * Parses the file specified
     * 
     * @param  FileInterface $file 
     * @return array
     */
    public function parse(FileInterface $file)
    {
        return Yaml::parse($file->getContents());
    }
}