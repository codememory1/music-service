FROM php:8.1-fpm

ARG app_path
ARG workdir

WORKDIR $workdir

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY $app_path ./

EXPOSE 9000

CMD ["php-fpm"]