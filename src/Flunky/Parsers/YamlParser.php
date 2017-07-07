<?php

namespace Flunky\Parsers;

use Symfony\Component\Yaml\Yaml;
use Flunky\Files\Contracts\FileInterface;
use Flunky\Exceptions\InvalidFileException;
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
        if ($file->extension() !== $this->getHandledExtension()) {
            throw new InvalidFileException('Invalid file. You should pass a file that has .yaml extension.');
        }

        return Yaml::parse($file->getContents());
    }

    /**
     * Get file extension of the files it can handle
     *
     * @return string
     */
    public function getHandledExtension()
    {
        return 'yaml';
    }
}
