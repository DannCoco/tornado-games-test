FROM php:8.1.11-fpm

RUN apt-get update && apt-get install -y wget cron supervisor libzip-dev zip libpq-dev libpng-dev

RUN docker-php-ext-install zip pdo pgsql pdo_pgsql mysqli pdo_mysql gd

RUN pecl install xdebug && docker-php-ext-enable xdebug

# Create the log file
RUN touch /var/log/schedule.log
RUN chmod 0777 /var/log/schedule.log

# Add crontab file in the cron directory
ADD scheduler /etc/cron.d/scheduler

# Run the cron
RUN crontab /etc/cron.d/scheduler

# Copy supervisor configs
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Install Composer
COPY --from=composer:2.4.0 /usr/bin/composer /usr/bin/composer

COPY php_conf.ini /usr/local/etc/php/conf.d/990-custom.ini

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]