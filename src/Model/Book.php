<?php

namespace App\Model;

use App\Services\Doctrine;
use App\Entity\Publisher;
use DateTime;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;
use App\Entity\Book as BookEntity;
use App\Entity\Author as AuthorEntity;

class Book extends BaseModel
{
    public function getListAll(): array
    {
        return $this->em
            ->getRepository(BookEntity::class)
            ->createQueryBuilder('b')
            ->select('b.*')
            ->join("b.author_id", "a")
            ->leftJoin(Publisher::class, 'publisher', Join::WITH, 'b.publisher_id = publisher.id')
            ->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    //Создание книги с привязкой к существующему автору
    public function create($data): void
    {
        $author = $this->em->getRepository(AuthorEntity::class)->find($data['authorId']);
        if ($author) {
            $book = new BookEntity();
            $year = new DateTime($data['year']);
            $book->setTitle($data['title'])
                ->setYear($year)
                ->setPublisherId($data['publisher_id'])
                ->addAuthor($author);
            $author->addBook($book);
            $this->em->persist($book);
            $this->em->flush();
        }
    }

    //Удаление книги
    public function delete(int $bookID): void
    {
        $book = $this->em->find($bookID);
        $this->em->remove($book);
        $this->em->flush();
    }
}