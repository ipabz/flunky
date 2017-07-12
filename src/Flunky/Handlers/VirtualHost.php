<?php

namespace Flunky\Handlers;

use Flunky\Console\Command;

class VirtualHost extends Handler
{
    /**
     * @var array
     */
    protected $sites;

    /**
     * @var array
     */
    protected $folders;

    /**
     * @param string $basePath
     * @param array $config
     */
    public function __construct($basePath, $config)
    {
        parent::__construct($basePath);

        $this->sites = collect($config['sites']);

        $this->folders = $config['folders'];

        $this->command = new Command($basePath);
    }

    /**
     * @return array
     */
    protected function flattenFoldersToValue()
    {
        $result = [];

        foreach ($this->folders as $folder) {
            $result[] = $folder['to'];
        }

        return $result;
    }

    /**
     * @param  string $to
     * @param  array $mappings
     *
     * @return mixed
     */
    protected function getFolderMapping($to, $mappings)
    {
        foreach ($mappings as $map) {
            if (strpos("$to", "$map") !== false) {
                return $map;
            }
        }

        return false;
    }

    /**
     * Generate VirtualHosts
     *
     * @return void
     */
    public function run()
    {
        $contents   = $this->read('stubs/virtualhost.stub');
        $toMappings = $this->flattenFoldersToValue();

        $this->sites->each(function ($site) use ($contents, $toMappings) {
            $map = $site['map'];
            $to  = $site['to'];

            $mapping = $this->getFolderMapping($to, $toMappings);

            $prepContents = $this->prepareContent($contents, $map, $to, $mapping);
            $this->createVirtualHost($prepContents, $map);
        });
    }

    /**
     * Prepare Content
     *
     * @param  string $contents
     * @param  string $map
     * @param  string $to
     * @param  array $folderMappings
     *
     * @return string
     */
    protected function prepareContent($contents, $map, $to, $folderMappings)
    {
        $toTemp             = explode('/', $to);
        $folderMappingsTemp = explode('/', $folderMappings);

        $path = $folderMappingsTemp[count($folderMappingsTemp) - 1]
                . str_replace($folderMappings, '', $to);

        $publicHmtl = '/var/www/html/' . $path;

        $data = [
            'ServerName coolexample.com'                               => 'ServerName ' . $map,
            'ServerAlias www.coolexample.com'                          => 'ServerAlias www.' . $map,
            'DocumentRoot /var/www/coolexample.com/public_html'        => 'DocumentRoot ' . $publicHmtl,
            'ErrorLog /var/www/coolexample.com/error.log'              => 'ErrorLog ' . $publicHmtl . '/error.log',
            'CustomLog /var/www/coolexample.com/requests.log combined' => 'CustomLog ' . $publicHmtl . '/requests.log combined'
        ];

        foreach ($data as $replaceThis => $replaceWith) {
            $contents = str_replace($replaceThis, $replaceWith, $contents);
        }

        return $contents;
    }

    /**
     * Create a VirtualHost
     *
     * @param  string $contents
     * @param  string $map
     *
     * @return void
     */
    protected function createVirtualHost($contents, $map)
    {
        $siteAvailable = '/etc/httpd/sites-available/' . $map . '.conf';
        $siteEnabled   = '/etc/httpd/sites-enabled/' . $map . '.conf';

        $this->command->run("sudo echo '$contents' > $siteAvailable");
        $this->command->run("sudo ln -s $siteAvailable $siteEnabled");
    }
}
