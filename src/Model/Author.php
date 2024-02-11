<?php

namespace App\Model;

use App\Entity\Book as BookEntity;
use App\Entity\Author as AuthorEntity;
use DateTime;
use App\Services\Doctrine;

class Author
{
// Создание нового автора
// Удаление автора
    public function create(array $data): void
    {
        $author = new AuthorEntity();
        $author->setName($data['name'])
            ->setSurname($data['surname']);

        if (isset($data['edition']))
        {
            $author->addBook($data['book_id']);
        }

        Doctrine::getEntityManager()->persist($author);
        Doctrine::getEntityManager()->flush();
    }

}