#!/bin/sh
set -e

cd /app

PORT="${PORT:-10000}"

if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set. Add it under Render → Environment (copy from local .env)."
    exit 1
fi

php artisan config:clear 2>/dev/null || true
php artisan package:discover --ansi 2>/dev/null || true

if php artisan migrate --force; then
    echo "Database migrations completed."
else
    echo "WARN: migrations failed. Check DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD on Render."
    echo "      db4free: enable remote MySQL and allow connections from any host."
fi

php artisan storage:link 2>/dev/null || true

echo "Starting server on 0.0.0.0:${PORT}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
