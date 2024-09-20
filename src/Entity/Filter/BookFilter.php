<?php

namespace App\Entity\Filter;

use App\Entity\BookCopy;
use App\Entity\Rent;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


class BookFilter
{
   
    private ?string $title = null;
    private ?string $isbn = null;
    private ?string $category = null;
    private ?string $author = null;
    private ?\DateTimeInterface $publication_year = null;
    private Collection $bookCopies;
    private Collection $rents;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getPublicationYear(): ?\DateTimeInterface
    {
        return $this->publication_year;
    }

    public function setPublicationYear(\DateTimeInterface $publication_year): static
    {
        $this->publication_year = $publication_year;

        return $this;
    }

    // /**
    //  * @return Collection<int, BookCopy>
    //  */
    // public function getBookCopies(): Collection
    // {
    //     return $this->bookCopies;
    // }

    // public function addBookCopy(BookCopy $bookCopy): static
    // {
    //     if (!$this->bookCopies->contains($bookCopy)) {
    //         $this->bookCopies->add($bookCopy);
    //         $bookCopy->setBook($this);
    //     }

    //     return $this;
    // }

    // public function removeBookCopy(BookCopy $bookCopy): static
    // {
    //     if ($this->bookCopies->removeElement($bookCopy)) {
    //         // set the owning side to null (unless already changed)
    //         if ($bookCopy->getBook() === $this) {
    //             $bookCopy->setBook(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Rent>
    //  */
    // public function getRents(): Collection
    // {
    //     return $this->rents;
    // }

    // public function addRent(Rent $rent): static
    // {
    //     if (!$this->rents->contains($rent)) {
    //         $this->rents->add($rent);
    //         $rent->setBookCopy($this);
    //     }

    //     return $this;
    // }

    // public function removeRent(Rent $rent): static
    // {
    //     if ($this->rents->removeElement($rent)) {
    //         // set the owning side to null (unless already changed)
    //         if ($rent->getBookCopy() === $this) {
    //             $rent->setBookCopy(null);
    //         }
    //     }

    //     return $this;
    // }
}
