# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'yaml'

basePath = $basePath ||= File.expand_path(File.dirname(__FILE__))

flunkyYamlPath = basePath + "/Flunky.yaml"

require File.expand_path(File.dirname(__FILE__) + '/scripts/flunky.rb')

Vagrant.configure("2") do |config|
    if File.exist? flunkyYamlPath then
        settings = YAML::load(File.read(flunkyYamlPath))
    else
        abort "Flunky settings file not found in #{basePath}"
    end

    Flunky.configure(config, settings)
end
