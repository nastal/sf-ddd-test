FROM phpdockerio/php:8.2-fpm
WORKDIR "/app"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \
        librabbitmq-dev \
        php8.2-intl \
        php8.2-amqp \
        php8.2-ds \
        php8.2-pgsql \
        && pecl install amqp \
        && docker-php-ext-enable amqp \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
