#!/bin/bash
set -e

echo "⏳ Ждём готовности MySQL..."
until php -r "
    new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASSWORD')
    );
    echo 'ok';
" 2>/dev/null | grep -q ok; do
    sleep 2
done

echo "✅ MySQL готов. Запускаем миграции..."
php /var/www/html/protected/yiic.php migrate \
    --migrationPath=application.migrations \
    --interactive=0

echo "🚀 Запускаем Apache..."
exec apache2-foreground
