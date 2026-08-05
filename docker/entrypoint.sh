#!/bin/sh
set -e

# El volumen bind-mount de código pisa el vendor/ ya instalado en la imagen
# solo la primera vez que arranca el volumen nombrado "vendor_data" (vacío);
# a partir de ahí Composer solo corre si realmente falta el autoloader.
if [ ! -f vendor/autoload.php ]; then
    composer install --no-dev --optimize-autoloader
fi

if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

# Si APP_KEY ya llegó por variable de entorno (env_file en Dokploy, por
# ejemplo) no intentamos regenerarla: Laravel la toma igual y "key:generate"
# tira error porque no puede pisar una env var ya seteada por el proceso.
if [ -z "$APP_KEY" ] && [ -f .env ] && ! grep -q '^APP_KEY=base64' .env; then
    php artisan key:generate --force
fi

php artisan storage:link 2>/dev/null || true

# Espera a que MySQL acepte conexiones antes de migrar (evita la carrera
# contra el healthcheck de "db" en el primer arranque en frío).
until php -r '
    $dsn = sprintf("mysql:host=%s;port=%s;dbname=%s", getenv("DB_HOST"), getenv("DB_PORT"), getenv("DB_DATABASE"));
    try {
        new PDO($dsn, getenv("DB_USERNAME"), getenv("DB_PASSWORD"));
        exit(0);
    } catch (Throwable $e) {
        exit(1);
    }
' >/dev/null 2>&1; do
    echo "Esperando a la base de datos..."
    sleep 2
done

php artisan migrate --force

exec "$@"
