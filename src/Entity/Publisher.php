<?php

namespace App\Entity;

use App\Repository\PublisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;

#[ORM\Entity(repositoryClass: PublisherRepository::class)]
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
    private string $address;

    /**
     * One Publisher has many Books.
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'publisher_id', indexBy: 'title')]
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

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Publisher
    {
        $this->address = $address;
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

    public function addBookId(Book $bookId): static
    {
        if (!$this->book_id->contains($bookId)) {
            $this->book_id->add($bookId);
            $bookId->setPublisherId($this);
        }

        return $this;
    }

    public function removeBookId(Book $bookId): static
    {
        if ($this->book_id->removeElement($bookId)) {
            // set the owning side to null (unless already changed)
            if ($bookId->getPublisherId() === $this) {
                $bookId->setPublisherId(null);
            }
        }

        return $this;
    }
}