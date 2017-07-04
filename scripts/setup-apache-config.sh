#!/usr/bin/env bash

sudo rm -f /etc/httpd/conf/httpd.conf
sudo cat /vagrant/stubs/httpd.conf.stub > /etc/httpd/conf/httpd.conf