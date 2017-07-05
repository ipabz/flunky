## Installation & Setup

### Prerequisites

Before launching your Flunky environment, you must install <a target="_blank" href="https://www.virtualbox.org">VirtualBox</a> and <a target="_blank" href="https://vagrantup.com">Vagrant</a>. These software packages provide easy-to-use visual installers for all popular operating systems.

### Installing Flunky

You may install Flunky by simply cloning the repository. Consider cloning the repository into a  `Flunky` folder within your "home" directory, as the Flunky box will serve as the host to all of your PHP projects:

```
cd ~

git clone https://github.com/ipabz/flunky.git Flunky
```

Once you have cloned the Flunky repository, run the `bash scripts/init.sh` command from the Flunky directory to create the `Flunky.yaml` configuration file. The `Flunky.yaml` file will be placed in the `~/Flunky` directory:

```
bash scripts/init.sh
```

## Configuring Flunky

### Configuring Shared Folders

The `folders` property of the `Flunky.yaml` file lists all of the folders you wish to share with your Flunky environment. As files within these folders are changed, they will be kept in sync between your local machine and the Flunky environment. You may configure as many shared folders as necessary:

```
folders:
    - map: ~/Projects
      to: /home/vagrant/Projects
```

### Configuring Apache Sites

Not familiar with Apache? No problem. The `sites` property allows you to easily map a "domain" to a folder on your Flunky environment. A sample site configuration is included in the  `Flunky.yaml` file. Again, you may add as many sites to your Flunky environment as necessary. Flunky can serve as a convenient, virtualized environment for every PHP project you are working on:

```
sites:
    - map: my-project.dev
      to: /home/vagrant/Projects/my-project
```

If you change the `sites` property after provisioning the Flunky box, you should re-run  `vagrant reload --provision` to update the Apache configuration on the virtual machine.

### The Hosts File

You must add the "domains" for your Apache sites to the `hosts` file on your machine. The hosts file will redirect requests for your Flunky sites into your Flunky machine. On Mac and Linux, this file is located at `/etc/hosts`. On Windows, it is located at  `C:\Windows\System32\drivers\etc\hosts`. The lines you add to this file will look like the following:

```
192.168.33.10  my-project.dev
```

Make sure the IP address listed is the one set in your `~/Flunky/Flunky.yaml` file. Once you have added the domain to your `hosts` file and launched the Vagrant box you will be able to access the site via your web browser:

```
http://my-project.dev
```

