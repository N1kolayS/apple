## Быстрый запуск

Запуск через docker.

### Инициализация и конфигурация

Инициализация проекта yii2
```
./init
```


Установка подключения к БД
```php
'db' => [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=mysql;dbname=yii2advanced',
    'username' => 'yii2advanced',
    'password' => 'secret',
    'charset' => 'utf8',
],
```

Применение миграций

```
./yii migrate
```

### Авторизация
Так как не нужна сложная система авторизации, и нужен вход только по паролю, 
была использована модель без базы данных. Пароль admin