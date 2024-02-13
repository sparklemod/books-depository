<?php

namespace App\Entity;

use App\Repository\BookRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'Books')]
class Book
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
    private string $title;

    /**
     * @var int
     */
    #[ORM\Column(type: 'smallint')]
    private int $year;

    /**
     * Many Books have Many Authors.
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: 'Author', mappedBy: "books")]
    private Collection $authors;

    /** Many Books have one Publisher */
    #[ORM\ManyToOne(targetEntity: Publisher::class, inversedBy: 'book_id')]
    #[ORM\JoinColumn(name: 'publisher_id', referencedColumnName: 'id', onDelete: 'cascade')]
    private Publisher|null $publisher = null;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Book
    {
        $this->title = $title;
        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): Book
    {
        $this->year = $year;
        return $this;
    }

    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function setAuthors(Collection $authors): Book
    {
        $this->authors = $authors;
        return $this;
    }

    public function getPublisherId(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisherId(?Publisher $publisher): Book
    {
        $this->publisher = $publisher;
        return $this;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        $this->authors->removeElement($author);

        return $this;
    }
}