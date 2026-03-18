# Запуск приложения

```shell
git clone https://github.com/ghostITwe/my-blog.git
cd my-blog
cp .env.example .env
```

## Обновить значения в '.env'
```shell
SESSION_DRIVER=file
CACHE_STORE=file
```

## Установить зависимости
```shell
composer install
npm install
```

## Сгенерировать ключ приложения
```shell
php artisan key:generate
```

## Подготовить storage и базу данных
```shell
php artisan storage:link
php artisan migrate --seed
```

## Запустить приложение
```shell
php artisan serve
npm run dev
```

## Дефолтные аккаунты
```text
Админ: admin@example.com / password
Пользователь: user@example.com / password
```

