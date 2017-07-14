<?php

return [
    'Parsers' => [
        "yaml" => "Flunky\\Parsers\\YamlParser"
    ],
    'Handlers' => [
        "Flunky\\Handlers\\Linker",
        "Flunky\\Handlers\\Mysql",
        "Flunky\\Handlers\\VirtualHost"
    ]
];
