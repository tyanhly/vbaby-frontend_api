FROM ubuntu:16.04
VOLUME /var/www/html/app
WORKDIR /var/www/html/app

COPY . .
COPY init.sh /
EXPOSE 80
CMD ["/init.sh"]