<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PublisherController extends AbstractController
{
    #[Route('/publisher', name: 'app_publisher')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PublisherController.php',
        ]);
    }

    public function edit(array $data): void
    {
        $publisher = $this->em->getRepository(PublisherEntity::class)->find($data['id']);
        $publisher->setName($data['name'])
            ->setAddress($data['address'])
            ->setBookId($data['book_id']);

        $this->em->persist($publisher);
        $this->em->flush();
    }

    public function delete(int $publisherId): void
    {
        $publisher = $this->em->getRepository(PublisherEntity::class)->find($publisherId);
        $this->em->remove($publisher);
        $this->em->flush();
    }
}
