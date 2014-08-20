The Development Environment
===========================

First up I will be using a Linux system in all my examples, therefore most of
the content in terms of using the command line and configuration should
translate directly to Mac OS X users. For Windows users things may be a little
bit different but shouldn't be too hard to work out.

Requirements
------------

The only real requirement for working through this book is that you are using
PHP 5.5 or above. Throughout this book we will be using PHP both from the
command line as well as in a webserver environment.

Where we are using it in a web environment I will be using a tool called
Vagrant which allows you to run your development environment in a virtual
machine on your computer, this removes the need to set up and configure a
webserver (or database servers) directly on your computer and therefore is the
way I would recommend doing it. However if you did want to set up the relevent
webserver & database servers on your development machine manually then you
could do that if you like.

Vagrant
-------

Vagrant is a neat little tool, it allows many developers working on the same
project to easily run a local copy of the projects environment without having
to install all the projects dependencies on their development machines. It does
this by bulding and running a virtual machine for a config file included in the
project.

Vagrant itself simply instructs a virtualisation provider on what type of
virtual machine and then uses configuration automation system to configure that
virtual machine.

Different providers such as VMWare are available for use with Vagrant but I
will be using VirtualBox.

Also different configuration automation systems such as Chef and Puppet can be
used with Vagrant but I am choosing to use Ansible, I just prefer the syntax.

### Installing

In order to use Vagrant you will need to install:

* Vagrant - http://www.vagrantup.com/
* VirtualBox - http://www.virtualbox.org/
* Ansible - http://www.ansible.com/

I recommend that you install both Vagrant and VirtualBox by downloading the
distribution packages directly from their websites.

With Ansible you need to make sure you have an up to date version, on Ubuntu I
tend to get mine for Rodney Quillo's PPA which as it's more up to date than the
version in the Software Center. This PPA can be found at:

`https://launchpad.net/~rquillo/+archive/ubuntu/ansible`

### Creating a Vagrant Config for PHP Development

Once you have Vagrant, VirtualBox and Ansible installed it's time to build a
Vagrant configuration.

It's not hard to build a Vagrant configfile by hand, or to build the config
automation scripts, but it is a bit tedious and not really something this
book intends to cover. Luckily there are some online tools available which make
this process a whole lot easier. Since we want to build a PHP development
environment and we're going to use Ansible lets using http://www.phansible.com/
to do this for us.

First of all open `http://www.phansible.com/` in your browser.

You will see a form asking questions about the development enviroment that you
want to create, for this example choose the following options:

Operating System: **Ubuntu Trusty Tahr (14.04) 64**
Name: **Vagrant Example**
IP Address: **192.168.5.1** (you can use different local IP address if you want but remember it as we will need to know it shortly)
Memory: **512**
Shared Folder: **./**

Webserver: **Apache + PHP5**

PHP Version: 5.5

Ignore the Database and Package settings for now and finally choose an
appropriate Timezone.

Next click the **Generate** button at the bottom and save the generated `.zip`
file to your hard drive.

#### Creating the Project

Now we have the Vagrant configuration generated let's create a PHP project and
add the Vagrant configuration to it.

At your terminal `cd` to where ever you want to create your project:

`cd /home/tom/Projects`

Next create a folder for your new project and `cd` into it:

```
mkdir VagrantExample
cd VagrantExample
```

Now create a file inside this directory called `index.php` with your favourite
IDE/text editor and add the following contents:

```php
<?php

echo 'Hello wonderful World!';
```

Now unpack the contents of the Vagrant configuration `.zip` file that we
downloaded from the Phansible website, I saved my file to
`/home/tom/Downloads/phansible_VagrantExample.zip`:

`unzip /home/tom/Downloads/phansible_VagrantExample.zip`

Finally, while still inside the project's directory and with your computer
connected to the Internet, type:

`vagrant up`

This may take some time and you may be prompted to enter your sudo password but
be patient.

When it is done open your browers and enter the IP address we selected earlier into the location bar like so:

`http://192.168.5.1/`

If all has gone to plan you should see `Hello wonderful World!` displayed on
the page! Success, we have created a PHP development enviroment for our project
without installing and configuring a webserver on our local machine.

Once you have marvelled in the glory of Vagrant you can shut it down by typing:

`vagrant halt`

at your command line.

**PLEASE NOTE: I have found if I forget to shutdown my virtual machines on before
I try to shutdown my computer it hangs during the shutdown process.. If you have
a solution to this problem I'd love to heard it.**
