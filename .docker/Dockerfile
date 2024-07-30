FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies for production
RUN apt-get update && apt-get install -y \
    bash \
    curl \
    g++ \
    gcc \ 
    git \
    imagemagick \
    libcurl4-openssl-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    libicu-dev \
    libzip-dev \
    make \
    nodejs \
    yarn \
    openssh-client \
    rsync \
    zip \
    unzip \
    supervisor \
    nginx \
    build-essential

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    iconv \
    intl \
    exif \
    gd \
    pcntl \
    bcmath \
    mysqli \
    pdo \
    pdo_mysql \
    opcache \
    xml \
    mbstring \
    sockets \
    zip

# Install PECL and PEAR extensions
RUN pecl install apcu \
    redis \
    xdebug

# Enable PECL and PEAR extensions
RUN docker-php-ext-enable apcu \
    redis \
    xdebug

# Configure extensions
RUN docker-php-ext-configure zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# If you need to fix ssl
COPY ./conf/openssl.cnf /etc/ssl/openssl.cnf

# If you need add extension
COPY ./conf/php.ini /usr/local/etc/php/php.ini

# Copy nginx/php/supervisor configs
# RUN cp ./conf/supervisor.conf /etc/supervisord.conf
# RUN cp ./conf/openssl.cnf /etc/ssl/openssl.cnf
# RUN cp ./certs/ssl_certs.crt  /etc/ssl/certs/ssl_certs.crt
# RUN cp ./certs/ssl_key.key  /etc/ssl/certs/ssl_key.key
# RUN cp ./conf/php.ini /usr/local/etc/php/conf.d/app.ini
# RUN cp ./conf/default.conf /etc/nginx/conf.d/default.conf
# RUN cp ./conf/default /etc/nginx/sites-available/default

# Set composer related environment variables
ENV PATH="/vendor/bin:/composer/vendor/bin:$PATH" \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_VENDOR_DIR=/var/www/html/vendor \
    COMPOSER_HOME=/composer

# Change www-data user to match the host system UID and GID and chown www directory
RUN usermod --uid $uid $user \
    && groupmod --gid $uid $user \
    && chown -R $user:$user /var/www \
    && chgrp -R $user /var/www

# Get latest Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP CodeSniffer
# RUN composer global require "squizlabs/php_codesniffer=*"

# Set working directory
WORKDIR /var/www/html

# Copy existing code to /var/www/html directory
# COPY . .

# Install application dependencies
# RUN composer install
# RUN composer install --optimize-autoloader --no-scripts --no-autoloader --ansi --no-interaction

# Run composer to update
# RUN composer update --optimize-autoloader
# RUN composer update --no-dev --no-interaction --prefer-dist --no-suggest --ignore-platform-req=ext-http --ignore-platform-req=ext-xdebug

# Generate an optimized autoloader
# RUN composer dump-autoload --optimize --classmap-authoritative

# Change chmod www directory
RUN chmod -R 777 /var/www/html
# RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Enable PHP short tags for Laravel
RUN echo "short_open_tag = On" > /usr/local/etc/php/conf.d/short-tags.ini

# Configure Git
RUN git config --global user.email "balakarthikeyan07@gmail.com" \ 
    && git config --global user.name "Balakarthikeyan"

# Change current user to $user
USER $user

# Generate the application key
# RUN php artisan key:generate

# RUN remove cache
# RUN php artisan config:cache && php artisan route:cache 

# Setup working directory
# CMD php artisan serve --host=localhost --port=8000
# EXPOSE 80 443

# Run supervisor
# CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

# ENTRYPOINT ["php", "artisan", "serve", "-host localhost", "-port 8000" ]