#!/bin/sh
set -e

echo "Ejecutando el script docker-entrypoint.sh..."

if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ -f composer.json ]; then
	echo "Ejecutando comandos..."

	composer install --prefer-dist --no-progress --no-interaction

	chmod -R 775 public
	chmod -R 775 var/cache/

	php bin/console cache:clear --env=prod

	php bin/console make:migration
	php bin/console doctrine:migrations:migrate
fi

exec docker-php-entrypoint "$@"
