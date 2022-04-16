FROM antopol12/php8.0-apache-git-composer:1.0

RUN docker-php-ext-install pdo_mysql

RUN mkdir -p /var/www/html/storage/logs\
    && chmod -R 777 /var/www/html/storage/logs\
    && chown -R www-data:www-data /var/www/html/storage/logs

RUN composer install --ignore-platform-reqs --no-scripts
