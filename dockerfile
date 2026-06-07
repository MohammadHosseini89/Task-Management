# Start with PHP base image
FROM php:8.1-apache 

# Install required extensions and packages
RUN apt-get update && apt-get install -y \
        libzip-dev libpq-dev unzip \ 
    && docker-php-ext-install pdo pdo_mysql zip bcmath \
    && a2enmod rewrite

# Set ownership and permissions for the storage directory
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage/framework/views/



# Copy Laravel application files
COPY --chown=www-data:www-data . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install additional dependencies
# RUN apt-get update && apt-get install -y \
#         libapache2-mod-wsgi-py3 \
#         python3-pip \
#         mysql-server


# # Configure MySQL 
# ENV MYSQL_ROOT_PASSWORD myrootpassword
# ENV MYSQL_DATABASE saca
# ENV MYSQL_USER myuser
# ENV MYSQL_PASSWORD mypassword

# # Enable Apache modules
# RUN a2enmod rewrite

# # Copy Laravel Apache configuration
# COPY laravel.conf /etc/apache2/sites-available/000-default.conf

# # Set the timezone
# ENV TZ=Asia/Tehran
# RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# # # Install MySQL 
# # FROM mysql
# # RUN docker-php-ext-install pdo pdo_mysql

# # RUN apt-get install -y mysql-server

# # Install phpMyAdmin
  
# FROM php:8.1-apache as build
# RUN apt-get update && apt-get install -y unzip

# RUN curl -sSL https://files.phpmyadmin.net/phpMyAdmin/5.2.0/phpMyAdmin-5.2.0-all-languages.zip > phpmyadmin.zip
# RUN unzip phpmyadmin.zip -d /phpmyadmin

# FROM php:8.1-apache
# COPY --from=build /phpmyadmin /var/www/html/phpmyadmin
# # COPY --from=build /phpMyAdmin* /var/www/html/

# # RUN echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf


# # Configure phpMyAdmin
# ENV PMA_HOST db
# ENV PMA_PORT 3306 
# ENV PMA_USER root
# ENV PMA_PASSWORD myrootpassword

# # Install composer  
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Set working directory
# WORKDIR /var/www/html

# # Copy laravel project  
# COPY . /var/www/html

  
# # Install composer dependencies
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN composer install

# # Configure permissions  
# RUN usermod -u 1000 www-data
# RUN chown -R www-data:www-data /var/www/html

# RUN 

# # Expose port 80
# EXPOSE 80

# # Start Apache
# CMD ["apache2-foreground"]
