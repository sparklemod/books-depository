<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    private EntityRepository $authorRepository;
    private EntityRepository $bookRepository;
    private EntityRepository $publisherRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->authorRepository = $entityManager->getRepository(Author::class);
        $this->bookRepository = $entityManager->getRepository(Book::class);
        $this->publisherRepository = $entityManager->getRepository(Publisher::class);
        $this->entityManager = $entityManager;
    }

    #[Route('/book', name: 'app_book')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/BookController.php',
        ]);
    }

    #[Route('/book/getListAll', name: 'get_bookList', methods: ['GET'])]
    public function getListAll(): JsonResponse
    {
        $sql = $this->bookRepository
            ->createQueryBuilder('b')
            ->select('b.title as title, b.year as year, p.name as publisher, a.surname as author')
            ->innerJoin('b.authors', 'a', Join::WITH)
            ->leftJoin(Publisher::class, 'p', Join::WITH, 'b.publisher = p.id')
            ->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);

        return $this->json($sql);
    }

    #[Route('/book/create', name: 'post_bookCreate', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $publisher = $this->publisherRepository->find($data['publisher_id']);
        $author = $this->authorRepository->find($data['author_id']);

        if ($author) {
            $book = new Book();
            $book->setTitle($data['title'])
                ->setYear($data['year'])
                ->addAuthor($author);
            if ($publisher) {
                $book->setPublisherId($publisher);
            }
            $author->addBook($book);

            $this->entityManager->persist($book);
            $this->entityManager->flush();
            return $this->json(['message' => 'SUCCESS']);
        }

        return $this->json(['message' => 'Author not found']);
    }

    #[Route('/book/delete', name: 'app_book_delete', methods: ['DELETE'])]
    public function delete(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $book = $this->bookRepository->find($data['book_id']);

        if ($book) {
            $this->entityManager->remove($book);
            $this->entityManager->flush();
            return $this->json(['message' => 'Book successfully deleted']);
        }

        return $this->json(['message' => 'Book not found']);
    }
}
