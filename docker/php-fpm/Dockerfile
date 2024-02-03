FROM phpdockerio/php:8.2-fpm
WORKDIR "/app"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        git \
        php8.2-pgsql \
        php8.2-redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
RUN chown -R www-data:www-data /app
