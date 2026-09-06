FROM php:8.2-cli AS vendor

WORKDIR /app

RUN apt-get update \
    && apt-get install -y --no-install-recommends libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

FROM node:18 AS assets

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources ./resources
COPY webpack.mix.js ./
RUN npm run production

FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" bcmath exif gd pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public ./public
COPY . .

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && php artisan package:discover --ansi

# Do NOT use `php artisan serve` here.
#
# ServeCommand spawns the PHP server as a child process and rebuilds its
# environment from a small allow-list (ServeCommand::$passthroughVariables:
# APP_ENV, LARAVEL_SAIL, PATH, PHP_CLI_SERVER_WORKERS, PHP_IDE_CONFIG,
# SYSTEMROOT, XDEBUG_*). Every other variable is explicitly unset in the child.
#
# Because .env is excluded from this image (.dockerignore), Railway's variables
# are the only source of configuration - and artisan serve strips all of them,
# so APP_KEY, DB_* and MYSQL* never reach the process that handles requests.
# That surfaces as a 500 on every route.
#
# This line runs the same server artisan would have (docroot = public/, with
# ../server.php as the mod_rewrite shim) while inheriting the full environment.
# `exec` keeps PHP as PID 1 so it receives Railway's shutdown signals.
CMD ["sh", "-c", "cd public && exec php -S 0.0.0.0:${PORT:-8080} ../server.php"]