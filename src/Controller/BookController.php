<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use DateTime;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BookController.php',
        ]);
    }

    #[Route('/book/getList', name: 'app_book_list')]
    public function getListAll(EntityManagerInterface $entityManager): JsonResponse
    {
       $sql = $entityManager
            ->getRepository(Book::class)
            ->createQueryBuilder('b')
            ->select('b.title as title, b.year as year, p.name as publisher, a.surname as author')
            ->innerJoin('b.authors', 'a', Join::WITH)
            ->leftJoin(Publisher::class, 'p', Join::WITH, 'b.publisher = p.id')
            ->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);

        return $this->json($sql);
    }

    #[Route('/book/create', name: 'app_book-create')]
    //Создание книги с привязкой к существующему автору
    public function create(EntityManagerInterface $entityManager): JsonResponse
    {
        $year = new DateTime;
        $year->format('Y');
        $data = [
            'authorId' => 27,
            'title' => 'title',
            'year' => $year,
            'publisher_id' => 1
        ];
        $publisher = $entityManager->getRepository(Publisher::class)->find($data['publisher_id']);
        $author = $entityManager->getRepository(Author::class)->find($data['authorId']);

        if ($author) {
            $book = new Book();
            $book->setTitle($data['title'])
                ->setYear($data['year'])
                ->addAuthor($author);

            if ($publisher)
            {
                $book->setPublisherId($data['publisher_id']);
            }

            $author->addBook($book);
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->json($book);
        }

        return $this->json([
            'message' => 'error'
        ]);
    }

    #[Route('/book/delete', name: 'app_book_delete')]
    //Удаление книги
    public function delete(EntityManagerInterface $entityManager): JsonResponse
    {
        $bookID = 25;
        $book = $entityManager->getRepository(Book::class)->find($bookID);
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json([
            'message' => 'success'
        ]);
    }
}
