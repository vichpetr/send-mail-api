#FROM phpearth/php:7.4-apache
#
#RUN apk --no-cache add bash vim curl php7-pdo php7-pdo_mysql
#
#RUN echo "ServerName localhost" >> /etc/apache2/httpd.conf
#CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]


FROM debian

RUN apt update && apt upgrade -y
RUN apt install wget apache2 bash -y

RUN apt -y install lsb-release apt-transport-https ca-certificates
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg

RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list

RUN apt update  -y
RUN apt install php libapache2-mod-php php8.1-mysql php8.1-common php8.1-mysql php8.1-xml php8.1-xmlrpc php8.1-curl php8.1-gd php8.1-imagick php8.1-cli php8.1-dev php8.1-imap php8.1-mbstring php8.1-opcache php8.1-soap php8.1-zip php8.1-intl -y

RUN a2dissite 000-default
RUN mkdir -p /var/www/html/localhost/public

RUN chmod -R 755 /var/www/html/localhost
RUN chown -R www-data:www-data /var/www/html/localhost

COPY ./config/localhost.conf /etc/apache2/sites-available/

RUN a2ensite localhost.conf

EXPOSE 80
