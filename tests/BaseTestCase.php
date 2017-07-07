<?php

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    /**
     * @var string
     */
    private $basePath;

    /**
     *
     */
    public function __construct()
    {
        $this->basePath = dirname(__DIR__) . '/';

        $this->init();
    }

    /**
     * Initialize
     *
     * @return void
     */
    abstract public function init();

    /**
     * Get base path
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Get path prepended with the base path
     *
     * @param  string $path
     * @return string
     */
    public function path($path)
    {
        return $this->getBasePath() . $path;
    }
}
