#!/usr/bin/env bash

composer install

cat stubs/Flunky.yaml.stub > Flunky.yaml

echo "Flunky initiliazed!";