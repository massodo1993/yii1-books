FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    unzip \
    git \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd \
        --with-jpeg=/usr/include \
        --with-webp=/usr/include \
        --with-freetype=/usr/include

RUN docker-php-ext-install -j"$(nproc)" \
        pdo \
        pdo_mysql \
        mbstring \
        gd \
        zip \
        fileinfo

RUN a2enmod rewrite

RUN chmod 1777 /tmp

RUN sed -i 's/AllowOverride None/AllowOverride All/g' \
        /etc/apache2/apache2.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN mkdir -p uploads/covers protected/runtime \
 && chown -R www-data:www-data uploads protected/runtime \
 && chmod -R 755 uploads protected/runtime

RUN mkdir -p /var/www/html/assets \
 && chown -R www-data:www-data /var/www/html/assets \
 && chmod -R 755 /var/www/html/assets

EXPOSE 80