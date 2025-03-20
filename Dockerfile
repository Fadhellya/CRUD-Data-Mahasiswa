FROM php:8.2-apache

# Install dependencies to allow using apt and MySQL client
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
    default-mysql-client; \
    docker-php-ext-install mysqli pdo pdo_mysql; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*

# Copy your application files to the container
COPY . /var/www/html/

# Set proper permissions for the web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# **Mengubah Apache agar berjalan di port 8080**
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/' /etc/apache2/sites-available/000-default.conf

# Expose port 8080
EXPOSE 8080

# Start Apache in the foreground
CMD ["apache2-foreground"]
