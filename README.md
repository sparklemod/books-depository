# Документация по установке и запуску
1. Загрузите проект https://github.com/sparklemod/books-depository
2. Экспортируйте базу данных BooksDepository. Находится в корневой папке проекта
3. Установите пакеты, указанные в composer.json
4. Запустите сервер symfony в папке проекта и сервер, обеспечивающий работу БД
5. Выполните команду для наполнения БД тестовыми данными `php bin/console doctrine:fixtures:load` (опционально)
6. Используйте любой HTTP-клиент для тестирования API (например, Postman)

### Доступные команды
`php bin/console app:remove-authors-without-books` - удаление всех авторов, у которых нет книг <br/>
`php bin/console doctrine:fixtures:load` - наполнение БД тестовыми данными 

### Доступные методы
`GET` **/book/getList** <br/>
Получение всех книг (помимо полей книги, возвращает фамилию автора и наименование издательства) <br/> 
`POST` **/book/create** <br/> 
Создание книги с привязкой к существующему автору. "publisher_id" опциональное поле
```
{
    "author_id": "int",
    "title": "string",
    "year": "int",
    "publisher_id": "int"
}
```
`DELETE` **/book/delete** <br/> 
Удаление книги
```
{
    "book_id": "int"
}
```
`PUT` **/publisher/edit** <br/> 
Редактирование издателя
```
{
    "publisher_id": "int",
    "name": "string",
    "address": "string"
}
```
`DELETE` **/publisher/delete** <br/> 
Удаление издателя
```
{
    "publisher_id": "int"
}
```
`POST` **/author/create** <br/> 
Создание нового автора. "book_id" опциональное поле
```
{
    "name": "string",
    "surname": "string",
    "book_id": "int"
}
```
`DELETE` **/author/delete** <br/> 
Удаление автора
```
{
    "author_id": "int"
}
```
