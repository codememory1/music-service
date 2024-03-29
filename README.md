<p align="center">
    <img src="/bin/assets/codememory-logo.svg" alt="Codememory company" width="300" height="110"/>
</p>

## YouTrack agile
> https://codememory.youtrack.cloud/

> Login: git@sumron-music.com

> Password: sumron

## Ветки

> **master** - Продакшн ветка _(Используется на реальном продакшн сервере)_

> **env/demo-production** - Ветка демонстрации продакшн _(Используется на демо сервере)_

> **env/development** - Ветка для разработки _(Используется локально)_

## Установка проекта

- ### Сборка контейнеров и запуск
```
> docker-compose up -d
```

- ### Настройка окружения

> Создайте файл __.env.local__ в __api/__ и скопируйте всю конфигурацию __api/.env__ в данный файл и начните настраивать все параметры

- ### Инициализация секретных ключей для JWT-токенов
```
> bin/jwt-init
```

- ### Выполнение миграций
```
> bin/migration
```

- ### Загрузка фикстукр
```
> bin/load-fixtures
```

- ### Установка зависимостей
> Перейдите в контейнер php и установите зависимости __composer__
```
> docker-compose exec api sh
> composer install
```

== Зависимости устновлены и проект готов к работе ==
