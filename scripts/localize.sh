#!/usr/bin/env bash

# Set language
echo "export LANG=$1" >> ~/.bashrc
echo "export LANG=$1" >> /home/vagrant/.bashrc

# Remove message after login
sudo echo '' > /etc/motd