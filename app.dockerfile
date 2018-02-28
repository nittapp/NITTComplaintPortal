FROM shakyshane/laravel-php:latest

COPY . /var/www
COPY composer.lock composer.json /var/www/

COPY database /var/www/database

WORKDIR /var/www

RUN chown -R www-data:www-data \
        /var/www/storage \
        /var/www/bootstrap/cache

RUN sh /var/www/composer_install.sh

RUN php artisan optimize
