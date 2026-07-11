#!/bin/sh
set -e

if [ -n "$DB_HOST" ] && [ -n "$DB_PORT" ]; then
    echo "Waiting for database at $DB_HOST:$DB_PORT..."
    for i in $(seq 1 30); do
        if php -r "exit(@fsockopen(getenv('DB_HOST'), (int) getenv('DB_PORT')) ? 0 : 1);"; then
            echo "Database is up."
            break
        fi
        sleep 2
    done
fi

php artisan config:clear
php artisan migrate --force

php artisan db:seed --force --class=Database\\Seeders\\DatabaseSeeder || true

if [ -n "$ADMIN_EMAIL" ] && [ -n "$ADMIN_PASSWORD" ]; then
    php artisan tinker --execute="
        if (!\App\Models\User::where('email', env('ADMIN_EMAIL'))->exists()) {
            \App\Models\User::create([
                'name' => 'Maxime Maazaoui',
                'email' => env('ADMIN_EMAIL'),
                'password' => bcrypt(env('ADMIN_PASSWORD')),
            ]);
        }
    " || true
fi

php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
