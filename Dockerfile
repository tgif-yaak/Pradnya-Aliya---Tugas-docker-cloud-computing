FROM php:8.2-apache

# Install ekstensi PHP untuk MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy semua file ke direktori di dalam container
COPY . /var/www/html

# Pindahkan document root ke folder 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# Hak akses
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
