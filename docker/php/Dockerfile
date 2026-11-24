# PHP B-Tree image: PHP 8.3 CLI with Graphviz and Composer.
# If you change an image name here, change BASE_IMAGES in the Makefile too,
# so that make remove keeps deleting it.

FROM php:8.3-cli

# Graphviz draws the B-tree images with its dot command.
# unzip lets composer unpack the packages it downloads.
RUN apt-get update \
    && apt-get install -y --no-install-recommends graphviz unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY php.ini /usr/local/etc/php/conf.d/php-b-tree.ini
