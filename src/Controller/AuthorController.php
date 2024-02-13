<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthorController.php',
        ]);
    }

    #[Route('/author/create', name: 'app_author_create')]
    public function createAuthor(EntityManagerInterface $entityManager): Response
    {
        $data = [
            'name' => 'John',
            'surname' => 'Doe',
            'book_id' => 1
        ];
        $author = new Author();
        $author->setName($data['name'])
            ->setSurname($data['surname']);

        if (isset($data['edition']))
        {
            $author->addBook($data['book_id']);
        }

        $entityManager->persist($author);
        $entityManager->flush();

        return new Response('Saved new author with id '.$author->getId());
    }

    public function delete(EntityManagerInterface $entityManager): void
    {
        $authorId = 25;
        $author = $entityManager->getRepository(Author::class)->find($authorId);
        $entityManager->remove($author);
        $entityManager->flush();
    }
}
