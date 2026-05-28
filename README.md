# Book Catalog — Yii1

Каталог книг с авторами, RBAC, подпиской гостей и SMS-уведомлениями.

## Стек

- **PHP 8+**
- **Yii 1.1** (устанавливается через Composer)
- **MySQL / MariaDB**

---

## Установка

### 1. Установить зависимости

```bash
composer install
```

### 2. Создать базу данных

```sql
CREATE DATABASE book_catalog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Настроить подключение

Отредактировать `protected/config/main.php`:

```php
'db' => array(
    'connectionString' => 'mysql:host=localhost;dbname=book_catalog;charset=utf8mb4',
    'username'         => 'YOUR_USER',
    'password'         => 'YOUR_PASSWORD',
),
```

### 4. Запустить миграции

```bash
php protected/yiic.php migrate --migrationPath=application.migrations
```

### 5. Прописать ключ SMS Pilot

В `protected/config/main.php` → `params.smsPilotApiKey`.
Ключ-эмулятор берётся в личном кабинете [smspilot.ru](https://smspilot.ru/apikey.php).

### 6. Настроить веб-сервер

**Apache** — `.htaccess` уже есть, убедитесь что `mod_rewrite` включён.

**Nginx** пример:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 7. Создать директорию для загрузок

```bash
mkdir -p uploads/covers
chmod 755 uploads uploads/covers
```

---

## Структура проекта

```
.
├── index.php                        # Точка входа
├── .htaccess                        # Правила mod_rewrite
├── composer.json
├── uploads/                         # Обложки книг (создать вручную)
└── protected/
    ├── config/
    │   ├── main.php                 # Основная конфигурация
    │   └── console.php              # Конфигурация консоли (для миграций)
    ├── migrations/
    │   ├── m001_create_users_table.php
    │   ├── m002_create_authors_table.php
    │   ├── m003_create_books_table.php
    │   ├── m004_create_book_author_table.php
    │   └── m005_create_subscriptions_table.php
    ├── models/
    │   ├── User.php
    │   ├── Author.php
    │   ├── Book.php
    │   ├── Subscription.php
    │   └── LoginForm.php
    ├── controllers/
    │   ├── SiteController.php       # login / logout / register
    │   ├── BookController.php       # CRUD книг
    │   ├── AuthorController.php     # CRUD авторов
    │   ├── ReportController.php     # ТОП-10
    │   └── SubscriptionController.php
    ├── views/
    │   ├── layouts/main.php
    │   ├── book/       index, view, _form
    │   ├── author/     index, view, _form
    │   ├── report/     index
    │   ├── subscription/ create
    │   └── site/       login, register, error
    ├── components/
    │   ├── UserIdentity.php         # Аутентификация
    │   └── SmsPilot.php             # Отправка SMS
    └── data/
        └── auth.php                 # RBAC-роли (CPhpAuthManager)
```

---

## Права доступа

| Действие                          | Гость | Юзер |
|-----------------------------------|-------|------|
| Просмотр книг и авторов           | ✅    | ✅   |
| Просмотр ТОП-10                   | ✅    | ✅   |
| Подписка на автора (SMS)          | ✅    | ❌   |
| Добавление / редактирование книги | ❌    | ✅   |
| Добавление / редактирование автора| ❌    | ✅   |
| Удаление книги / автора           | ❌    | ✅   |

---

## SMS-уведомления

При добавлении новой книги автоматически отправляется SMS всем гостям,
подписанным на хотя бы одного из авторов книги.

Используется API [smspilot.ru](https://smspilot.ru/apikey.php).
Для тестирования — ключ-эмулятор (реальной отправки нет, API отвечает штатно).
