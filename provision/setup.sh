#!/usr/bin/env bash
echo "Provisioning virtual machine..."

echo "Update..."
apt-get update 


echo "Installing Git"
apt-get install git -y > /dev/null

echo "Apache:"
apt-get install -y apache2 apache2-utils  > /dev/null
apt-get install -y libapache2-mod-php5 > /dev/null

echo "ServerName localhost" > "/etc/apache2/conf-available/fqdn.conf"
a2enconf fqdn
a2enmod rewrite
a2enmod php5
a2enmod proxy_fcgi

a2dissite 000-default.conf

# Apache / Virtual Host Setup
echo "----- Provision: Install Host File..."
cp /var/www/provision/chat.conf /etc/apache2/sites-available/chat.conf
a2ensite chat.conf

cp /var/www/provision/chatServer.conf /etc/apache2/sites-available/chatServer.conf
a2ensite chatServer.conf

# Restart Apache


echo "Updating PHP repository"
apt-get install python-software-properties build-essential -y > /dev/null
add-apt-repository ppa:ondrej/php5 -y > /dev/null
# sudo add-apt-repository -y ppa:ondrej/php5-5.6
apt-key update
apt-get update > /dev/null

echo "Installing PHP"
apt-get install php5-common php5-dev php5-cli php5-fpm -y > /dev/null
    
echo "Installing PHP extensions"
apt-get install curl php5-curl php5-gd php5-mcrypt php5-sqlite php5-xdebug php5-json -y > /dev/null

echo "----- Provision: Restarting Apache..."
service apache2 restart
# Cleanup
apt-get -y autoremove

echo "Installing supervisor"
apt-get install supervisor -y >/dev/null

cp /var/www/provision/deamon.conf /etc/supervisor/conf.d/deamon.conf > /dev/null
# service supervisor restart