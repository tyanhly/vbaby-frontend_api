#!/bin/bash
apt-get install net-tools
a2enmod rewrite
service apache2 restart
echo "${MYSQL_IPADDRESS} mysqlserver" >> /etc/hosts
composer update
php artisan migrate
sleep 1000000000