<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 5; $i++) {
            $author = new Author();
            $author->setName('author'.$i)
            ->setSurname('surname'.$i);

            $publisher = new Publisher();
            $publisher->setName('publisher'.$i)
            ->setAddress('address'.$i);

            $book = new Book();
            $book->setTitle('book'.$i)
            ->setYear(2024 - $i)
            ->setPublisherId($publisher)
            ->addAuthor($author);

            $author->addBook($book);
            $publisher->addBookId($book);

            $manager->persist($author);
            $manager->persist($publisher);
            $manager->persist($book);
        }

        $manager->flush();
    }
}
