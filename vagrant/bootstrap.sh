#!/usr/bin/env bash

###################
##Package Prompts##
###################

#MySQL
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

#PHPMyAdmin
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/dbconfig-install boolean true'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/app-password-confirm password root'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/admin-pass password root'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/mysql/app-pass password root'
sudo debconf-set-selections <<< 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2'

#Install software packages
sudo apt-get -y update
sudo apt-get -y install apache2 php5 php5-dev php5-curl php5-mcrypt libpcre3-dev php-http php5-mysql libmysqlclient-dev build-essential phpmyadmin mysql-server vim curl

#Set timezone
echo "Europe/London" | sudo tee /etc/timezone
sudo dpkg-reconfigure --frontend noninteractive tzdata

#Configure PHP
sudo php5enmod mcrypt
sudo service apache2 restart

#########################
##Project specific setup##
#########################

#Add Vhost file
VHOST=$(cat <<EOF
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName dev.project

        DocumentRoot /var/www/project

        ErrorLog /var/log/apache2/project_error.log
        CustomLog /var/log/apache2/project_access.log combined
</VirtualHost>
EOF
)
echo "${VHOST}" > /etc/apache2/sites-available/dev.project.conf

sudo a2ensite dev.project.conf
sudo service apache2 restart

#Add to hosts file
sudo -- sh -c "echo 127.0.1.1  dev.project >> /etc/hosts"

#Create DB
SQL=$(cat <<EOF
CREATE DATABASE project;
GRANT USAGE ON *.* TO project@localhost IDENTIFIED BY 'project';
GRANT ALL PRIVILEGES ON project.* TO project@localhost;
FLUSH PRIVILEGES;
EOF
)
mysql -uroot -proot -e "${SQL}"
