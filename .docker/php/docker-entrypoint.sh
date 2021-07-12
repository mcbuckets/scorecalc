#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

mkdir -p var/cache var/log

if [ ! -f composer.json ]; then
    composer create-project "symfony/skeleton $SYMFONY_VERSION" tmp --stability=$STABILITY --prefer-dist --no-progress --no-interaction
    jq '.extra.symfony.docker=true' tmp/composer.json > tmp/composer.tmp.json
    rm tmp/composer.json
    mv tmp/composer.tmp.json tmp/composer.json

    cp -Rp tmp/. .
    rm -Rf tmp/
elif [ "$APP_ENV" != 'prod' ]; then
    rm -f .env.local.php
    composer install --prefer-dist --no-progress --no-suggest --no-interaction
fi

setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var

exec docker-php-entrypoint "$@"
