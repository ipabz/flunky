class Flunky
    def Flunky.configure(config, settings)
        # Configure The Box
        config.vm.define settings["name"] ||= "flunky"
        config.vm.box = settings["box"] ||= "icpabelona/flunky"
        config.vm.hostname = settings["hostname"] ||= "flunky"

        # Set scripts base path
        scriptDir = File.dirname(__FILE__)

        # Use default language unless overriden
        language = settings["lang"] ||= "en_PH"

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

        # Register Shared Folder Container
        config.vm.synced_folder "~", "/vagrant_data"

        # Set locale
        config.vm.provision "shell" do |s|
            s.name = "Setting locale: " + language
            s.path = scriptDir + "/localize.sh"
            s.args = [language]
        end

        # Set apache config
        config.vm.provision "shell" do |s|
            s.name = "Setting apache config..."
            s.path = scriptDir + "/setup-apache-config.sh"
        end

        # Set php.ini
        config.vm.provision "shell" do |s|
            s.name = "Setting php.ini..." 
            s.path = scriptDir + "/setup-php-ini.sh"
        end

        # Clear apache
        config.vm.provision "shell" do |s|
            s.name = "Clearing existing apache container..." 
            s.path = scriptDir + "/clear-apache.sh"
        end

        # Create apache container
        config.vm.provision "shell" do |s|
            s.name = "Creating apache container..." 
            s.path = scriptDir + "/create-apache-container.sh"
        end

        # Set mysql config
        config.vm.provision "shell" do |s|
            s.name = "Setting mysql config..." 
            s.path = scriptDir + "/setup-mysql-config.sh"
        end

        # Run flunky
        config.vm.provision "shell" do |s|
            s.name = "Running flunky..." 
            s.path = scriptDir + "/flunky.sh"
        end

        # Start apache
        config.vm.provision "shell" do |s|
            s.name = "Starting apache..." 
            s.path = scriptDir + "/start-apache.sh"
        end

    end
end