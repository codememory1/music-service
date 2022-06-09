<p align="center">
    <img src="/bin/assets/codememory-logo.svg" alt="Codememory company" width="300" height="110"/>
</p>

## Установка проекта

- ### Сборка контейнеров и запуск
```
> docker-compose build
```

- ### Настройка окружения

> Создайте файл __.env.local__ в __api/__ и скопируйте всю конфигурацию __api/.env__ в данный файл и начните настраивать все параметры

- ### Инициализация JWT-токенов
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
