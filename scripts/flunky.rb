class Flunky
    def Flunky.configure(config, settings)
        # Configure The Box
        config.vm.define settings["name"] ||= "flunky"
        config.vm.box = settings["box"] ||= "icpabelona/flunky"
        config.vm.hostname = settings["hostname"] ||= "flunky"

        # Configure A Private Network IP
        config.vm.network :private_network, ip: settings["ip"] ||= "192.168.33.10"

        # Configure A Few VirtualBox Settings
        config.vm.provider "virtualbox" do |vb|
            vb.name = settings["name"] ||= "flunky"
            vb.customize ["modifyvm", :id, "--memory", settings["memory"] ||= "1024"]
            vb.customize ["modifyvm", :id, "--cpus", settings["cpus"] ||= "1"]
            
            if settings.has_key?("gui") && settings["gui"]
                vb.gui = true
            end
        end

        # Standardize Ports Naming Schema
        if (settings.has_key?("ports"))
            settings["ports"].each do |port|
                port["guest"] ||= port["to"]
                port["host"] ||= port["send"]
                port["protocol"] ||= "tcp"
            end
        else
            settings["ports"] = []
        end

        # Default Port Forwarding
        default_ports = {
            80 => 8000,
            443 => 44300,
            3306 => 33060
        }

        # Use Default Port Forwarding Unless Overridden
        unless settings.has_key?("default_ports") && settings["default_ports"] == false
            default_ports.each do |guest, host|
                unless settings["ports"].any? { |mapping| mapping["guest"] == guest }
                    config.vm.network "forwarded_port", guest: guest, host: host, auto_correct: true
                end
            end
        end

        # Register Shared Folders
        config.vm.synced_folder "~", "/vagrant_data"

        # Run additional customizations for vagrant box
        config.vm.provision :shell, :path => "scripts/bootstrap.sh"

    end
end