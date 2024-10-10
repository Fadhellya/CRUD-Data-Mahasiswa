FROM php:8.2-apache

# Install necessary PHP extensions and MySQL client
RUN apt-get update && apt-get install -y \
    mysql-client \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Copy your application files to the container
COPY . /var/www/html/

# Set proper permissions for the web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 to make the web service available outside the container
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
