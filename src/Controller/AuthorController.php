<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    private EntityRepository $authorRepository;
    private EntityRepository $bookRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->authorRepository = $entityManager->getRepository(Author::class);
        $this->bookRepository = $entityManager->getRepository(Book::class);
        $this->entityManager = $entityManager;
    }

    #[Route('/author/create', name: 'author_bookCreate', methods: ['POST'])]
    public function createAuthor(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $author = new Author();
        $author->setName($data['name'])
            ->setSurname($data['surname']);

        $book = $this->bookRepository->find($data['book_id']);

        if (isset($data['book_id']) && $book !== null) {
            $author->addBook($book);
        }

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return new Response('Saved new author with id ' . $author->getId());
    }

    #[Route('/author/delete', name: 'delete_authorDelete', methods: ['DELETE'])]
    public function delete(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $author = $this->authorRepository->find($data['author_id']);

        if ($author) {
            $this->entityManager->remove($author);
            $this->entityManager->flush();
            return new Response('SUCCESS: Author was deleted');
        }

        return new Response('ERROR: Author not found');
    }
}
