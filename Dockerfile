FROM php:8.1-apache

# Установка PDO MySQL
RUN docker-php-ext-install pdo_mysql

# Включение модуля rewrite для Apache
RUN a2enmod rewrite

# Настройка кодировки для Apache
RUN echo "AddDefaultCharset UTF-8" >> /etc/apache2/apache2.conf

# Копирование файлов приложения
COPY app/ /var/www/html/

# Права для Apache
RUN chown -R www-data:www-data /var/www/html