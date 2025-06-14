ARG PHP_VERSION=8.4
ARG CADDY_VERSION=2

# -----------------------------------------------------
# Caddy Install
# -----------------------------------------------------
FROM caddy:$CADDY_VERSION-builder AS builder
ARG TARGETPLATFORM
ARG BUILDPLATFORM
ARG TARGETOS
ARG TARGETARCH

RUN CGO_ENABLED=0 GOOS=$TARGETOS GOARCH=$TARGETARCH xcaddy build

# -----------------------------------------------------
# Base image
# -----------------------------------------------------
FROM php:$PHP_VERSION-fpm AS base

ARG PORT=9001
ARG PUBLIC_DIR=public

ENV PORT=$PORT
ENV PUBLIC_DIR=$PUBLIC_DIR
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_NO_INTERACTION=1 COMPOSER_CACHE_DIR="/tmp"
ENV PHP_INI_SCAN_DIR=":$PHP_INI_DIR/app.conf.d"

ENV EXTENSIONS="amqp apcu ast bcmath exif ffi gd gettext gmp igbinary imagick intl opcache pcntl pdo_mysql pdo_pgsql redis sockets sysvmsg sysvsem sysvshm uuid xsl zip gd"

ENV BUILD_DEPS="make git autoconf wget"

# Caddy
COPY --from=builder /usr/bin/caddy /usr/local/bin/caddy

# Composer install
COPY --from=composer/composer:2-bin /composer /usr/bin/composer

WORKDIR /app

# Copying manifest files to host
COPY ./docker/manifest /

# php extensions installer: https://github.com/mlocati/docker-php-extension-installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install required packages
RUN apt-get update && apt-get install -y --no-install-recommends ${BUILD_DEPS} \
        acl \
        file \
        gettext \
        procps \
        supervisor \
        unzip \
        zip \
        imagemagick \
        webp \
        gifsicle \
        jpegoptim \
        optipng \
        pngquant \
	&& rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN set -eux; install-php-extensions $EXTENSIONS

# Update ulimit
RUN ulimit -n 16384

# Entrypoint
COPY --link --chmod=755 ./docker/entrypoint.sh /usr/local/bin/docker-entrypoint

# PHP config
COPY --link ./docker/conf.d/10-app.ini $PHP_INI_DIR/app.conf.d/app_php.ini

# Install nodeJS
RUN curl -fsSL https://deb.nodesource.com/setup_23.x | bash - \
    && apt-get install -y nodejs && \
    node --version && \
    npm --version

ENTRYPOINT ["docker-entrypoint"]

# -----------------------------------------------------
# Local development image
# -----------------------------------------------------
FROM base AS local

ENV LOCAL_VM=true XDEBUG_MODE=off

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Install development packages
RUN apt-get update && apt-get -y --no-install-recommends install chromium chromium-driver nano zsh

# zsh
RUN sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)" \
    && git clone https://github.com/zsh-users/zsh-syntax-highlighting.git ${ZSH_CUSTOM:-~/.oh-my-zsh/custom}/plugins/zsh-syntax-highlighting \
    && curl -fsSL https://gist.githubusercontent.com/deluxetom/5175bd9d08ff2b1cee5d970460a66316/raw -o ~/.zshrc \
    && chsh -s $(which zsh) && ln -sf /usr/bin/zsh /bin/sh

RUN install-php-extensions xdebug

COPY --link ./docker/conf.d/20-app.local.ini $PHP_INI_DIR/app.conf.d/local_php.ini

# -----------------------------------------------------
# Production image for AWS ECSok

# -----------------------------------------------------
FROM base AS ecs

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# PHP config
COPY --link ./docker/conf.d/20-app.prod.ini $PHP_INI_DIR/app.conf.d/zzz_php.ini
COPY --link ./docker/conf.d/php-fpm-pool.conf /usr/local/etc/php-fpm.d/zzz_fpm-pool.conf

# Copy all files over
COPY . /app

# Composer Prod
RUN if [ "$APP_ENV" = "prod" ]; then \
	mkdir -p var/cache var/log; \
    composer install -n --prefer-dist --no-dev --no-scripts --no-progress; \
    composer dump-autoload --optimize --classmap-authoritative --no-dev; \
    composer dump-env prod; \
    composer run-script --no-dev post-install-cmd; \
    chmod +x bin/console; sync; fi

# Composer Dev
RUN if [ "$APP_ENV" != "prod" ]; then \
	mkdir -p var/cache var/log; \
    composer install -n --prefer-dist --no-scripts --no-progress; \
    composer clear-cache; \
    composer run-script post-install-cmd; \
    chmod +x bin/console; sync; fi

# Assets
RUN ./bin/console tailwind:build --minify -v && ./bin/console asset-map:compile
