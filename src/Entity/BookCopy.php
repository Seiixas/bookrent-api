<?php

namespace App\Entity;

use App\Repository\BookCopyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookCopyRepository::class)]
class BookCopy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bookCopies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['default'])]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'bookCopies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['default'])]
    private ?User $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
