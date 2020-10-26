FROM php:7.4-fpm-alpine

WORKDIR /var/www/html

# Setup GD extension
RUN apk add --no-cache \
      freetype \
      libjpeg-turbo \ 
      libpng \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
      oniguruma-dev \
      libxml2-dev \
      icu-dev \
      libzip-dev \
      libxslt-dev \
    && docker-php-ext-configure gd \
      --with-freetype=/usr/include/ \
      --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && rm -rf /tmp/*

RUN docker-php-ext-install \
    bcmath \
    intl \
    mbstring \
    mysqli \
    pcntl \
    pdo_mysql \
    soap \
    sockets \
    zip \
    xsl \
    gd 
  # && docker-php-ext-install opcache \
  # && docker-php-ext-enable opcache \
  # && pecl install amqp \
  # && docker-php-ext-enable amqp

RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');" && \
  php -r "if (hash_file('sha384', 'composer-setup.php') === 'c31c1e292ad7be5f49291169c0ac8f683499edddcfd4e42232982d0fd193004208a58ff6f353fde0012d35fdd72bc394') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
  php composer-setup.php --install-dir=/usr/bin --filename=composer && \
  php -r "unlink('composer-setup.php');"

RUN apk add vim

RUN chmod -R 777 .

# RUN cp .env.example .env

# RUN composer install

# RUN php artisan migrate

# RUN php artisan storage:link
