FROM phpswoole/swoole:5.1.4-php8.3-alpine

RUN docker-php-ext-install pcntl

RUN apk add autoconf gcc make g++ zlib-dev linux-headers

RUN pecl channel-update pecl.php.net
RUN pecl install xdebug

RUN apk del autoconf gcc make g++ zlib-dev linux-headers

WORKDIR /app

EXPOSE 9501

#ENTRYPOINT ["php", "hyperf", "start"]
ENTRYPOINT ["php", "hyperf", "server:watch"]