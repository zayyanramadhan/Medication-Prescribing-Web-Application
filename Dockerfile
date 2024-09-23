# Use the PHP 7.3 FPM image
FROM php:7.3-fpm

# Install the PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql
