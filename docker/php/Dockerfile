FROM php:7-fpm

RUN apt-get update

RUN apt-get install --fix-missing -y \
	libpng-dev \
	libjpeg-dev \
	libfreetype6-dev \
	vim

RUN docker-php-ext-install pdo pdo_mysql \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install gd  \
