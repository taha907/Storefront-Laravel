#!/bin/sh
cd /app || exit 1

PORT="${PORT:-10000}"

if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set. Render -> Environment -> APP_KEY (copy from local .env)."
    exit 1
fi

php artisan config:clear 2>/dev/null || true

# Uzak MySQL yavas/yanit vermezse migrate sunucuyu bloke eder -> Bad Gateway
if command -v timeout >/dev/null 2>&1; then
    timeout 60 php artisan migrate --force --no-ansi \
        || echo "WARN: migrate failed or timed out (site will still start)"
else
    php artisan migrate --force --no-ansi \
        || echo "WARN: migrate failed (site will still start)"
fi

php artisan migrate:status --no-ansi 2>/dev/null | tail -15 || true

php artisan storage:link 2>/dev/null || true

echo "Starting server on 0.0.0.0:${PORT}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
