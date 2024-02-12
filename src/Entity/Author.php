<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuthorRepository;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ORM\Table(name: 'Authors')]
class Author
{
    /**
     * @Id
     * @Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;
    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $name;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private string $surname;

    /**
     * Many Authors have Many Books.
     * @var Collection<int, Book>
     */
    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'author_id')]
    private Collection $books;

    public function __construct() {
        $this->books = new ArrayCollection();
    }

    /**
     * @param Book $book
     * @return $this
     */
    public function addBook(Book $book): Author
    {

        $this->books->add($book);
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Author
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Author
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): Author
    {
        $this->surname = $surname;
        return $this;
    }

    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function setBooks(Collection $books): Author
    {
        $this->books = $books;
        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            $book->removeAuthor($this);
        }

        return $this;
    }
}