<?php

/**
 * @param $configPath
 *
 * @return string
 */
function config($configPath)
{
    $path = explode('.', $configPath);

    $fileName           = array_shift($path);
    $configAbsolutePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Config';

    $fileManager = new \Flunky\Files\FileManager($configAbsolutePath);

    $files = $fileManager->listPhpFiles()->mapWithKeys(function ($file) use ($configAbsolutePath) {
        $name = str_replace('.php', '', $file);
        $path = $configAbsolutePath . DIRECTORY_SEPARATOR . $file;

        return [$name => $path];
    });

    $config = require($files[$fileName]);
    $key = array_shift($path);

    return isset($config[$key])
        ? $config[$key]
        : '';
}
