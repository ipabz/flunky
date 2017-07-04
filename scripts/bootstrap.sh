#!/usr/bin/env bash

# Set language
echo "export LANG=en_PH" >> ~/.bashrc
echo "export LANG=en_PH" >> /home/vagrant/.bashrc

# Remove message after login
sudo echo '' > /etc/motd

# Use our own httpd.conf setup
bash /vagrant/scripts/setup-apache-config.sh

# Use our own setup of php.ini
bash /vagrant/scripts/setup-php-ini.sh

# Create sites container
bash /vagrant/scripts/clear-apache.sh
bash /vagrant/scripts/create-apache-container.sh

# Set mysql config
bash /vagrant/scripts/setup-mysql-config.sh

# Initialize settings
sudo php /vagrant/flunky_init

# Start httpd
sudo service httpd start