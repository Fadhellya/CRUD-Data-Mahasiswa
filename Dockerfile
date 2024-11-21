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

# Expose port 8080 to make the web service available outside the container
EXPOSE 8080

# Start Apache in the foreground
CMD ["apache2-foreground"]
