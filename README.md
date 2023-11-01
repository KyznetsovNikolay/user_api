## Запуск приложения

- cd docker/ && docker compose up -d
- docker compose exec app composer install
- docker compose exec app bash
  - применить миграции
    
###  Работа с апи

host | port - localhost:8070
- /api/users [GET] - получить список пользователей
- /api/users/{id} [GET] - получить пользователя с id = {id}
- /api/users/{id} [DELETE] - удалить пользователя с id = {id}
- /api/users [POST] (payload with user data) - создать пользователя. 
  В теле запроса необходимы данные для создания нового пользователя
- /api/users/{id} [PUT] (payload with user data) - изменить пользователя.
  В теле запроса необходимы данные для изменения пользователя