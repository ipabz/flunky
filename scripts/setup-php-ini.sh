#!/usr/bin/env bash

sudo rm -f /etc/php.ini
sudo cat /vagrant/stubs/php.ini.stub > /etc/php.ini
