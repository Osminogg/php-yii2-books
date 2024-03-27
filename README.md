Сборка:
```bash
docker-compose up --build
```

Запуск:
```bash
docker exec -it books-php /bin/bash
composer install
```

Данные:
```bash
mysql
    root:secret
вход
    admin:admin
```

Запуск очереди с отправкой смс:
```bash
docker-compose exec books-php php yii queue/listen
```

Описание
```
На главной странице /site/index находится список популярных авторов.
Подписка на автора происходит на странице /author/view?id={id}
Отправка смс происходит в очереди, задача в которую создается при создании книги /book/create
```