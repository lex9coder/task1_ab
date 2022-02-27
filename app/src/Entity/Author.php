<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Book::class, mappedBy="authors")
     */
    private $authors;

    public function __construct()
    {
        $this->autors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Book $author): self
    {
        if (!$this->authors->contains($author)) {
            $this->authors[] = $author;
            $author->addAuthor($this);
        }

        return $this;
    }

    public function removeAuthor(Book $author): self
    {
        if ($this->authors->removeElement($author)) {
            $author->removeAuthor($this);
        }

        return $this;
    }

    public function json()
    {
        $author = [
            'id' => $this->id,
            'name' => $this->name
        ];
        return $author;
    }

}
