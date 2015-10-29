FROM php:5.6-apache

MAINTAINER Daniel Kokott <dako@berlingskemedia.dk>

# Installing wget - needed to download node.js
RUN apt-get update --fix-missing
RUN apt-get install -y libpq-dev php5-pgsql
RUN docker-php-ext-install pdo_pgsql

# Copying the code into image. Be aware no config variables are included.
COPY ./src /var/www/html/

# Exposing our endpoint to Docker.
EXPOSE 80

RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/servername.conf
RUN a2enconf servername

