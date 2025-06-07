#!/bin/sh

set -e

echo "Starting Container"

chmod +x /app/bin/console

if [ "$LOCAL_VM" = "true" ];
then
    composer install -n --prefer-dist --no-scripts --no-progress && npm i && npm run dev
fi

chmod -R 777 /app/var

# if CMD is use exec command
if [ "${1#-}" != "" ]; then
    echo "Running Command $@"
	exec "$@"
	exit 0
fi

# If we are in the development env, run migrations
echo "App ENV: ${APP_ENV}"
echo "Local VM: ${LOCAL_VM}"
echo "Debug: ${APP_DEBUG}"
echo "Starting Application"

/usr/bin/supervisord -n -c /etc/supervisord.conf
