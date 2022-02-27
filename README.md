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
> POST http://*_server_ip_*:10000/author/create
> {"name":"New Cowboys"}
>
> GET http://*_server_ip_*:10000/author/search?name=__name__
>
> PUT http://*_server_ip_*:10000/author/{id}
> {"name":"_author_name_"}
>
> DELETE http://*_server_ip_*:10000/author/{id}


## Books
> POST http://*_server_ip_*:10000/author/create
> {"name":"Eye on me", "author_id":10000}
>
> GET http://*_server_ip_*:10000/author/search?name=__name__
>
> GET http://*_server_ip_*:10000/{ru|en}/book/__ID__


## Далее сделать
> 1. Тесты
> 2. Мультиязычность
> 3. Перейти на прод окружение
> 4. Индесы
