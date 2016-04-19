#Simple RSS Feeds Manager

##About
A simple application to allow users to maintain a list of RSS feeds and to view their contents. The aim of this project was to better understand good application architecture design, OOP and SOLID principles.

##Installation

###Using Vagrant
First you will need to install both Vagrant and VirtualBox, if you don't already have them.

A vagrant file has been provided which will setup a pre-configured environment designed to get you up and running as quickly as possible.
Simply cd into the vagrant directory and run the command "vagrant up" -- this may take some time
Simply run "vagrant halt" to shutdown the server or "vagrant destroy" to delete it

As this creates a VHOST, you will need to add the following to your hosts file:
192.168.56.99 dev.project

--If you need to change the IP address then simply edit file: Vagrantfile

Once done, please go to http://dev.project/phpmyadmin (username: root, password: root) and import the base.sql file into database, project.

You have now successfully installed the application. You can access it from http://dev.project

###Custom Installation
You will need a LAMP stack with the following requirements:

 - PHP 5.5 with cURL and mcrypt
 - MySQL 5.5

The application sourcecode lies in the src folder so copy that to your server, and setup any necessary VHOSTS (adding any required entries to your hosts file, if necessary).
Create a database and a user, and update the database credentials in file: src/classes/Config.php

Import the base.sql file into your database.

Now access the application (http://dev.project) and you should be greeted by the welcome page. If you get any database errors, please confirm the credentials set in file: src/classes/Config.php
