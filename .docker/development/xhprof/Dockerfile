FROM php:7.2-fpm

ARG app_path
ARG workdir

WORKDIR $workdir

RUN apt-get update && apt-get install -y \
    curl \
    git \
    wget \
    unzip \
    libzip-dev \
    libxml2-dev \
    libonig-dev

# Insatll PHP Manager - Composer
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quite

COPY $app_path ./

EXPOSE 9000

CMD ["php-fpm"]