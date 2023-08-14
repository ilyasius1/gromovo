FROM phpdockerio/php:8.2-fpm
WORKDIR "/app"
USER root
RUN addgroup -g 1000 app && addgroup www-data app
RUN chown -R www-data:www-data /app
RUN adduser -u 1000 -s /bin/sh -D -G app app
USER www-data
