<?php

namespace App\Command;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"

#[AsCommand(
    name: 'app:remove-authors-without-books',
    aliases: ['app:remove-authors']
)]
class CustomCommand extends Command
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $authors = $this->entityManager->getRepository(Author::class)->findAll();

        foreach ($authors as $author) {
            if (count($author->getBooks()) === 0) {
                $this->entityManager->remove($author);
            }
        }

        $this->entityManager->flush();
        $output->writeln('Authors without books have been removed');

        return Command::SUCCESS;
    }
}