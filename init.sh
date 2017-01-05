#!/bin/bash
###########################################################################
# ultility functions
###########################################################################
set -e
cat > /etc/apache2/sites-available/000-default.conf << EOF 
<VirtualHost *:80> 
  ServerName mybaby.vn 
  DocumentRoot "/var/www/html/app" 
  <Directory "/var/www/html/app"> 
    AllowOverride all 
  </Directory> 
</VirtualHost> 
EOF

service apache2 restart