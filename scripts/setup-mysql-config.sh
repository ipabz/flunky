#!/usr/bin/env bash

sudo cat /vagrant/stubs/my.cnf.stub > /etc/my.cnf
sudo service mysqld restart