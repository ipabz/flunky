<?php

use Flunky\Files\File;
use Flunky\Parsers\YamlParser;

class YamlParserTest extends BaseTestCase
{
    /**
     * @var Flunky\Parsers\YamlParser
     */
    protected $parser;

    /**
     * Initialize
     *
     * @return void
     */
    public function init()
    {
        $this->parser = new YamlParser;
    }

    /**
     * @test
     */
    public function parse_a_yaml_file()
    {
        $yamlFile = new File($this->path('Flunky.yaml'));

        $result = $this->parser->parse($yamlFile);

        $this->assertTrue(is_array($result));
    }

    /**
     * @test
     * @expectedException Flunky\Exceptions\InvalidFileException
     */
    public function parse_not_a_yaml_file()
    {
        $yamlFile = new File($this->path('phpunit.xml'));

        $this->parser->parse($yamlFile);
    }

    /**
     * @test
     */
    public function get_handled_file_extension()
    {
        $this->assertEquals('yaml', $this->parser->getHandledExtension());
    }
}
