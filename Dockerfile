FROM phpearth/php:7.4-apache

RUN apk add --no-cache php7.4-sodium php7.4-intl php7.4-soap php7-pdo php7-pdo_mysql bash vim curl

RUN echo "ServerName localhost" >> /etc/apache2/httpd.conf
CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]
