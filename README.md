### Prerequisite

Before launching your Flunky environment, you must install <a target="_blank" href="https://www.virtualbox.org">VirtualBox</a> and <a target="_blank" href="https://vagrantup.com">Vagrant</a>. These software packages provide easy-to-use visual installers for all popular operating systems.

### Installation

1) ```cd ~ && git clone https://github.com/ipabz/flunky.git Flunky && cd ~/Flunky```

2) ```composer install```

3) ```bash scripts/init.sh```

4) Modify ~/Flunky/Flunky.yaml file based on your needs

5) Add the follow to your ~/.bashrc file

```
function flunky() {
    ( cd ~/Flunky && vagrant $* )
}
```

6) Then run this from anywhere

> This starts the virtual machine. At first, this will download the vagrant box which will take as much time depending on your internet connection. Take note that this will only download the box once and then the next time you run the command, it will just start the box you downloaded.

```
flunky up
```
