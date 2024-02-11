<?php

namespace App\Model;

use App\Services\Doctrine;
use App\Entity\Publisher;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;
use \App\Entity\Book as BookEntity;

class Book
{
    public function getListAll(): array
    {
        return Doctrine::getEntityManager()
            ->getRepository(BookEntity::class)
            ->createQueryBuilder('b')
            ->select('b.*')
            ->join("b.author_id", "a")
            ->leftJoin(Publisher::class, 'publisher', Join::WITH, 'b.publisher_id = publisher.id')
            ->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    //Создание книги с привязкой к существующему автору
    public function create(): void
    {
        $user = (new UserRepository())->find($userID);
        $book = new BookEntity();
        $year = new DateTime($data['year']);
        $book->setName($data['name'])
            ->setAuthor($data['author'])
            ->setEdition($data['edition'])
            ->setYear($year)
            ->addUser($user);
        $user->addBook($book);
        Doctrine::getEntityManager()->persist($book);
        Doctrine::getEntityManager()->flush();

    }

    //Удаление книги
}