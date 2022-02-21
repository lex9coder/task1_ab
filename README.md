# Установка

- Выполняется в консоли
- git clone https://github.com/lex9coder/task1_ab.git
- cd task1_ab
- docker-compose up --build -d
- docker-compose run --rm php composer install
- docker-compose run --rm php php bin/console doctrine:migrations:migrate --no-interaction
- docker-compose run --rm php php bin/console doctrine:fixtures:load --no-interaction
- открыть в браузере http://*_server_ip_*:10000/

## Authors
> GET http://*_server_ip_*:10000/author/search?name=33

> POST curl -d '{"name":"New Cowboys"}' -H "Content-Type: application/json" -X POST http://*_server_ip_*:10000/author/create

## Books
> GET http://*_server_ip_*:10000/{ru|en}/book/__ID__

> POST http://*_server_ip_*:10000/author/create

> POST curl -d '{"author_id":_ID__, "name":"new mega book"}' -H "Content-Type: application/json" -X POST http://*_server_ip_*:10000/book/create


## Далее сделать
> 1. Тесты
> 2. Мультиязычность
> 3. Посев данных выполнять в миграции
> 4. Перейти на прод окружение
> 5. Использовать symfony микросервис, не web