# Каталог книг — Yii1

**Стек:** PHP 8.2, Yii 1.1, MySQL, Docker

## Запуск через Docker

```bash
docker compose up --build -d

# Установить зависимости
docker compose run --rm app composer install

# Запустить миграции
docker compose exec app php yiic.php migrate --migrationPath=application.migrations --interactive=0
```

Приложение: http://localhost:8080
