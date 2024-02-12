<?php

namespace App\Model;
use \App\Entity\Publisher as PublisherEntity;
/*
    Редактирование издателя
    Удаление издателя
*/
class Publisher extends BaseModel
{
    public function edit(array $data): void
    {
        $publisher = $this->em->getRepository(PublisherEntity::class)->find($data['id']);
        $publisher->setName($data['name'])
        ->setAdress($data['address'])
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