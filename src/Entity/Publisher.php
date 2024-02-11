<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;

#[ORM\Entity]
#[ORM\Table(name: 'Publishers')]
class Publisher
{
    /**
     * @Id
     * @Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int|null $id = null;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $name;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $adress;

    /**
     * One Publisher has many Books.
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'publisher_id')]
    private Collection $book_id;

    public function __construct()
    {
        $this->book_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Publisher
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Publisher
    {
        $this->name = $name;
        return $this;
    }

    public function getAdress(): string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): Publisher
    {
        $this->adress = $adress;
        return $this;
    }

    public function getBookId(): Collection
    {
        return $this->book_id;
    }

    public function setBookId(Collection $book_id): Publisher
    {
        $this->book_id = $book_id;
        return $this;
    }
}