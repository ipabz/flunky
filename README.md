## Installation & Setup

### Prerequisites

Before launching your Flunky environment, you must install <a target="_blank" href="https://www.virtualbox.org">VirtualBox</a> and <a target="_blank" href="https://vagrantup.com">Vagrant</a>. These software packages provide easy-to-use visual installers for all popular operating systems.

### Installing Flunky

You may install Flunky by simply cloning the repository. Consider cloning the repository into a  Flunky folder within your "home" directory, as the Flunky box will serve as the host to all of your PHP projects:

```
cd ~

git clone https://github.com/ipabz/flunky.git Flunky
```

Once you have cloned the Flunky repository, run the bash scripts/init.sh command from the Flunky directory to create the Flunky.yaml configuration file. The Flunky.yaml file will be placed in the ~/Flunky directory:

```
bash init.sh
```
