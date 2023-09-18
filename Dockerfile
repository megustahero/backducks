FROM php:8.2-apache

#COPY ./src/ /usr/src/myapp

#WORKDIR /usr/src/myapp

# Install Postgre PDO
RUN apt-get update && apt-get install -y libpq-dev libpq5 perl libwww-perl \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql