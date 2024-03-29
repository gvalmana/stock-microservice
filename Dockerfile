FROM php:8.1.0-fpm

# Copy composer.lock and composer.json into the working directory
COPY composer.lock composer.json /var/www/html/

ENV ALEGRIA_MARKETPLACE_URL=https://recruitment.alegra.com/api/farmers-market/buy
ENV ALEGRIA_MARKETPLACE_AVAILABLE=0
ENV APP_COMUNICATION_PROTOCOL=kafka
ENV APP_SECURITY_KEY='123456'

ENV KAFKA_BROKERS=kafka:9093
ENV KAFKA_CONSUMER_GROUP_ID=my-group
ENV KAFKA_DEBUG=true

ENV DELIVERIES_INGREDIENTS_URL="http://api-deliveries/api"
ENV DELIVERIES_INGREDIENTS_WEBHOOK_ORDER_PATH="/webhooks/orders"
ENV REDIS_HOST=redis

ENV PUSHER_APP_ID=1757100
ENV PUSHER_APP_KEY=fbae1a5cebfef370361f
ENV PUSHER_APP_SECRET=3d5ae1ed0333e322cf87
# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    dnsutils \
    librdkafka-dev \
    nano \
    telnet

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions for php
RUN docker-php-ext-install mbstring zip exif pcntl
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install gd
RUN pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY . /var/www/html
# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache
RUN chmod -R 777 storage/ -R

RUN composer install
RUN composer fund
RUN composer dump-autoload
COPY .env.example .env
# COPY ./supervisor/laravel-workers.conf /etc/supervisor/conf.d/laravel-workers.conf
# COPY ./cron/example-crontab /etc/cron.d/example-crontab
# RUN chmod +x /etc/cron.d/example-crontab
# RUN chown root:root /etc/cron.d/example-crontab
# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 9000
CMD ["php-fpm"]
