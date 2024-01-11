FROM php:8.2.14-fpm


RUN apt update; \
    apt install -y --no-install-recommends \
            curl \
            libzip-dev \
            libxslt-dev \
            zip \
            unzip \
            mc

RUN docker-php-ext-install \
        pdo_mysql \
        zip \
        xsl \
        bcmath \
        opcache \
        mysqli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/bin --filename=composer &&\
    php -r "unlink('composer-setup.php');"


RUN mkdir /var/www/html/backend

ADD ./backend /var/www/html/backend

WORKDIR /var/www/html/backend

COPY ./backend/composer.json ./backend/composer.lock ./
RUN composer install #--no-scripts --no-autoloader

RUN useradd --user-group --system --create-home --no-log-init www
RUN usermod -u 1000 www-data
#RUN chown -R www-data:www-data storage
#RUN chmod -R 777 storage
#RUN chown -R www-data:www-data bootstrap/cache

CMD ["php-fpm"]

EXPOSE 9000