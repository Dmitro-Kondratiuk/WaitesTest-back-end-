# Тестове завдання(back-end) для компанії [Waites](https://waites.com.ua/)
Створено API на базі framework Yii-2.Було реалізовано створення поста,видалення,оновлення та перегляд.
Також реалізовано створення, оновлення та перегляд юзерів як одного юзера так і список усіх.Доступ до юзерів 
виконюється за допомогою [RBAC](https://www.yiiframework.com/doc/guide/2.0/en/security-authorization). Тобто 
доступ до всіх юзерів має тільки юзер з правами доступу адмін, інші мають право на перегляд постів.В ході розробки 
використовувався як локальний сервер [OpenServer](https://ru.wikipedia.org/wiki/Xinuos_OpenServer) version(5.4.1) 
Налаштуввання: база даних MySQL-5.7, PHP_7.2,HTTP Apache_2.4-PHP_7.2-7.4
## Встановлення 
1. Склонувати цей з github
## Налаштування
1. Виконайте команду в консолі `composer update`
2. Після встановленя потрібно підключити проєкт до бази даних в файлі config/db
```php
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=назва вашої таблиці в бд' ,
    'username' => 'ваш логін',
    'password' => 'ваш пароль',
    'charset' => 'utf8',
```

2. Після того як ви підключили базу даних до проєкту, потрібно буде виконати команду в консолі
`yii migrate`
3. Потім потробно на фронті створити користувача , автоматично йому буде надано роль admin
4. Також нам протріюно виконати міграію для повного функціонування RBAC `yii migrate --migrationPath=@yii/rbac/migrations/`
5. Переходимо до yii2 і на головній сторінці знаходимо ктопку Admin. Коли завершеться виконання коду ваш юзер стане 
   повноцінним Адміністратором
6. Всім подальшим зареєстрованим користувачам буде надано роль user


