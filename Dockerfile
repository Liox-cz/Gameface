FROM ghcr.io/liox-cz/php:8.2 as composer

ENV APP_ENV="prod"
ENV APP_DEBUG=0

# Unload xdebug extension by deleting config
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /app

# Intentionally split into multiple steps to leverage docker layer caching
COPY composer.json composer.lock symfony.lock ./

RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader



FROM node:14 as js-builder

WORKDIR /build

# We need /vendor here
COPY --from=composer /app .

# Install npm packages
COPY package.json package-lock.json webpack.config.js ./
RUN yarn install

# Production yarn build
COPY ./assets ./assets

RUN yarn run build


FROM composer as prod

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0

COPY .docker/nginx-unit /docker-entrypoint.d/

# Copy js build
COPY --from=js-builder /build .

# Copy application source code
COPY . .

# Need to run again to trigger scripts with application code present
RUN composer install --no-dev --no-interaction --classmap-authoritative

EXPOSE 8080

ARG APP_VERSION
ENV SENTRY_RELEASE="${APP_VERSION}"
