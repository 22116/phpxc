FROM composer:latest as composer

WORKDIR /home/phpxc

COPY ./composer.json /home/phpxc
COPY ./composer.lock /home/phpxc

RUN composer install --no-interaction --ignore-platform-reqs

FROM php:8.0-cli-alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions yaml

WORKDIR /home/phpxc

COPY --from=composer /home/phpxc/vendor /home/phpxc/vendor
COPY . /home/phpxc

ENTRYPOINT ["php", "bin/phpxc"]
