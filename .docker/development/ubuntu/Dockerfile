FROM ubuntu:22.04

RUN apt-get update && apt install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get install -y \
    curl \
    git \
    wget \
    unzip \
    php8.0-curl \
    php8.0-cli \
    php8.0-cgi \
    php8.0-mbstring \
    php-mysql \
    php8.0-xml \
    php8.0-zip \
    php8.0-gd \
    php8.0-pdo \
    redis

# Insatll PHP Manager - Composer
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quite