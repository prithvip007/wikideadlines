FROM php:7.4-apache-buster

WORKDIR /tmp

# Set new app folder for Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install NodeJS
RUN apt-get update
RUN apt-get install libpq-dev libzip-dev unzip git --assume-yes
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

# Install PHP extensions
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_pgsql

# Generate self-signed certificate
RUN openssl req -newkey rsa:2048 -new -nodes -x509 -days 3650 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/C=GB/ST=London/L=London/O=Global Security/OU=IT Department/CN=example.com"

# Enable Apache modules
RUN a2enmod rewrite
RUN a2enmod expires
RUN a2enmod ssl
RUN a2ensite default-ssl.conf

WORKDIR /var/www/html

# Copy must-have things for compilation
COPY ./artisan ./
COPY ./.env ./

RUN chown www-data:www-data -R /var/www/html
RUN chmod g+s /var/www/html

# Install composer packages
COPY ./composer.* ./
COPY ./database ./database
RUN php composer.phar install --no-scripts --no-dev

# Install npm packages
COPY ./package-lock.json ./
COPY ./package.json ./
RUN npm install

# Compile assets
COPY ./webpack.mix.js ./
COPY ./public ./public
COPY ./resources ./resources

RUN npm run prod

COPY . .

# Set permissions
RUN chgrp -R www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# Run composer post-autoload-dump scripts
RUN php composer.phar run-script post-autoload-dump

# Set up supervisor and config for laravel worker
RUN apt-get install supervisor --assume-yes
COPY ./laravel-worker.conf /etc/supervisor/conf.d

# Install pg_dump for background database backup
RUN apt-get install postgresql-client --assume-yes

RUN apt-get update && apt-get install cron --assume-yes
RUN echo "* * * * * root php /var/www/html/artisan schedule:run" >> /etc/crontab

EXPOSE 80
EXPOSE 443
