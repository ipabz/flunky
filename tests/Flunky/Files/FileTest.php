<?php

use Flunky\Files\File;
use Flunky\Files\Contracts\FileInterface;

class FileTest extends BaseTestCase
{
    /**
     * @var Flunky\Files\File
     */
    protected $file;

    /**
     * Initialize
     *
     * @return void
     */
    public function init()
    {
        $this->file = new File($this->path('Flunky.yaml'));
    }

    /**
     * @test
     */
    public function an_instance_of_file()
    {
        $this->assertInstanceOf(FileInterface::class, $this->file);
        $this->assertInstanceOf(File::class, $this->file);
    }

    /**
     * @test
     */
    public function get_file_contents()
    {
        $contents = $this->file->getContents();

        $this->assertTrue(is_string($contents));
    }

    /**
     * @test
     */
    public function get_fle_path()
    {
        $path = $this->file->path();

        $this->assertTrue(is_string($path));
        $this->assertEquals($this->path('Flunky.yaml'), $path);
    }

    /**
     * @test
     */
    public function get_file_extension()
    {
        $extension = $this->file->extension();

        $this->assertTrue(is_string($extension));
        $this->assertEquals('yaml', $extension);
    }
}
