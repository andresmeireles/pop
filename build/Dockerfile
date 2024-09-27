FROM phpswoole/swoole:5.1.4-php8.3-alpine

RUN docker-php-ext-install pcntl

WORKDIR /app

EXPOSE 9501

ENTRYPOINT ["php", "hyperf", "server:watch"]