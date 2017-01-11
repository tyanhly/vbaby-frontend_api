#!/bin/bash
set -e
ROOT=/var/www/html/app

###########################################################################
# ultility functions
###########################################################################
setupEnvVar () {
    local var_name=$1
    local var_val=$2
    echo "export $var_name=$var_val" >> ~/.bashrc
    echo "export $var_name=$var_val" >> /home/ubuntu/.bashrc
    export $var_name=$var_val
}

printMsg (){
    local msg=$1
    local d=$(date);
    echo  "$d: $msg"

}

printHeader () {
    local text=$1
    echo '********************'
    echo "* $text"
    echo '********************'
}

downloadFile () {
    local f=$1
    local name=$2
    if [ -f $f ];
    then
        echo "$f is downloaded"
    else
        echo "Start download $f"
    wget $f -O $name
    fi
}

###########################################################################
# Function
###########################################################################
installComposer () {
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '55d6ead61b29c7bdee5cccfb50076874187bd9f21f65d8991d46ec5cc90518f447387fb9f76ebae1fbbacf329e583e30') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    mv composer.phar /usr/local/bin/composer
}

installAdminer () {
    ADMINER_FILE=$ROOT/adminer.php
    ADMINER_GZ=$ROOT/adminer.php.gz
    printHeader "Install adminer"

    downloadFile https://raw.githubusercontent.com/tyanhly/adminer/master/adminer.php.gz $ADMINER_GZ
    cd $WEB_DIR && tar -xzf adminer.php.gz

    cat << EOF >  /etc/apache2/sites-available/adminer.conf
    Alias "/adminer" "$ADMINER_FILE"

EOF
    ln -s /etc/apache2/sites-available/adminer.conf /etc/apache2/sites-enabled/adminer.conf
}

installSofts(){

    apt-get update -y
    apt-get install apache2 php7.0 php7.0-zip php7.0-curl php7.0-json php7.0-xml php7.0-mysql php7.0-mbstring php7.0-mcrypt libapache2-mod-php7.0 -y
    a2enmod rewrite

    sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
    sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
    sudo apt-get -y install mysql-server

    cat > /etc/apache2/sites-available/000-default.conf << EOF
    <VirtualHost *:80>
      ServerName mybaby.vn
      DocumentRoot "$ROOT/public"
      <Directory "$ROOT/public">
        AllowOverride all
      </Directory>
    </VirtualHost>
EOF


}
###########################################################################
# Setup Env
###########################################################################

installSofts
installComposer
installAdminer
service apache2 restart
###########################################################################
# Setup Project
###########################################################################
cd $ROOT;
composer update --no-dev

