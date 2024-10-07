<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'books')]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $publication_year = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    // /**
    //  * @var Collection<int, BookCopy>
    //  */
    // #[ORM\OneToMany(targetEntity: BookCopy::class, mappedBy: 'book')]
    // #[Groups(['book'])]
    // private Collection $bookCopies;

    // /**
    //  * @var Collection<int, Rent>
    //  */
    // #[ORM\OneToMany(targetEntity: Rent::class, mappedBy: 'bookCopy')]
    // private Collection $rents;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $created_by = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
        $this->enabled = true;
        // $this->bookCopies = new ArrayCollection();
        // $this->rents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

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

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }
}
