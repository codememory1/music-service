FROM php:8.1.2-fpm

ARG app_path
ARG workdir

WORKDIR $workdir

RUN apt-get dist-upgrade && \
    apt-get update

RUN apt install -y  \
    lsb-release  \
    ca-certificates  \
    apt-transport-https  \
    software-properties-common gpg

RUN apt-get install -y gpg npm

RUN apt-get update && apt-get install -y \
    curl \
    git \
    wget \
    unzip \
    libcurl3-openssl-dev \
    redis \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    libpq-dev \
    bash  \
    bash-doc  \
    bash-completion

RUN docker-php-ext-install mysqli pdo zip pdo_mysql xml intl mbstring curl

RUN npm install

# Insatll PHP Manager - Composer
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quite
RUN composer global require bamarni/symfony-console-autocomplete

COPY $app_path ./

EXPOSE 9000

CMD ["php-fpm"]