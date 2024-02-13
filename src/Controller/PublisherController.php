<?php

namespace App\Controller;

use App\Entity\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PublisherController extends AbstractController
{
    private EntityRepository $publisherRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->publisherRepository = $entityManager->getRepository(Publisher::class);
        $this->entityManager = $entityManager;
    }

    #[Route('/publisher/edit', name: 'update_publisherEdit', methods: ['PUT'])]
    public function edit(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $publisher = $this->publisherRepository->find($data['publisher_id']);

        if ($publisher) {
            $publisher->setName($data['name'])
                ->setAddress($data['address']);

            $this->entityManager->persist($publisher);
            $this->entityManager->flush();
            return new Response('SUCCESS: Publisher was updated');
        }

        return new Response('ERROR: Publisher not found');
    }

    #[Route('/publisher/delete', name: 'delete_publisherDelete', methods: ['DELETE'])]
    public function delete(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $publisher = $this->publisherRepository->find($data['publisher_id']);

        if ($publisher) {
            $this->entityManager->remove($publisher);
            $this->entityManager->flush();
            return new Response('SUCCESS: Publisher was deleted');
        }

        return new Response('ERROR: Publisher not found');
    }
}
