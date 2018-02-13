FROM php:7.1.12-fpm

RUN apt-get  update

RUN apt-get install -y libicu52 libicu-dev && docker-php-ext-install intl

RUN pecl install xdebug-2.5.5 && docker-php-ext-enable xdebug

RUN apt-get install -y zlib1g-dev && docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/png/
RUN docker-php-ext-install -j$(nproc) gd

RUN mkdir /var/composer && chmod 0777 /var/composer

