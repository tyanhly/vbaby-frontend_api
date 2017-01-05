FROM ubuntu:16.04

WORKDIR /var/www/html/app

RUN apt-get update -y
RUN apt-get upgrade -y
RUN apt-get install -y \
  apache2 \
  php7.0 \
  php7.0-cli \
  libapache2-mod-php7.0 \
  php7.0-gd \
  php7.0-json \
  php7.0-ldap \
  php7.0-mbstring \
  php7.0-mysql \
  php7.0-pgsql \
  php7.0-sqlite3 \
  php7.0-xml \
  php7.0-xsl \
  php7.0-zip \
  php7.0-soap
RUN a2enmod rewrite

COPY . .
COPY init.sh /
EXPOSE 80
CMD ["/init.sh"]