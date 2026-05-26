#!/bin/sh
cd /app || exit 1

PORT="${PORT:-10000}"

if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set. Render -> Environment -> APP_KEY"
    exit 1
fi

php artisan config:clear 2>/dev/null || true

php artisan migrate --force --no-ansi 2>&1 || echo "WARN: migrate failed (server will still start)"

php artisan storage:link 2>/dev/null || true

echo "Starting server on 0.0.0.0:${PORT}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
