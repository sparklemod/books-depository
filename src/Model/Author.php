<?php

namespace App\Model;

use App\Entity\Author as AuthorEntity;

class Author extends BaseModel
{
// Создание нового автора ?+
// Удаление автора ?+
    public function create(array $data): void
    {
        $author = new AuthorEntity();
        $author->setName($data['name'])
            ->setSurname($data['surname']);

        if (isset($data['edition']))
        {
            $author->addBook($data['book_id']);
        }

        $this->em->persist($author);
        $this->em->flush();
    }

    public function delete(int $authorId): void
    {
        $author = $this->em->getRepository(AuthorEntity::class)->find($authorId);
        $this->em->remove($author);
        $this->em->flush();
    }

}