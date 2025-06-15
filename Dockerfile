FROM dunglas/frankenphp

ENV SERVER_NAME=:8080

RUN apt-get update && apt-get install -y \
    git \
    htop \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions \
	pdo_mysql \
	gd \
	intl \
	zip \
    redis \
    @composer \
    pcntl

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

EXPOSE 8080
