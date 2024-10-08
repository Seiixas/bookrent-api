<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    // /**
    //  * @var Collection<int, BookCopy>
    //  */
    // #[ORM\OneToMany(targetEntity: BookCopy::class, mappedBy: 'owner')]
    // #[Groups(['user_detail'])]
    
    // private Collection $bookCopies;

    // /**
    //  * @var Collection<int, Rent>
    //  */
    // #[ORM\OneToMany(targetEntity: Rent::class, mappedBy: 'lender_user')]
    // private Collection $rents;

    #[ORM\Column(length: 255)]
    private ?string $course = null;

    #[ORM\Column(length: 255)]
    private ?string $institution = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    // /**
    //  * @var Collection<int, Book>
    //  */
    // #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'created_by')]
    // private Collection $books;

    public function __construct()
    {
        // $this->bookCopies = new ArrayCollection();
        // $this->rents = new ArrayCollection();
        // $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
    //         $bookCopy->setOwner($this);
    //     }

    //     return $this;
    // }

    // public function removeBookCopy(BookCopy $bookCopy): static
    // {
    //     if ($this->bookCopies->removeElement($bookCopy)) {
    //         // set the owning side to null (unless already changed)
    //         if ($bookCopy->getOwner() === $this) {
    //             $bookCopy->setOwner(null);
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
    //         $rent->setLenderUser($this);
    //     }

    //     return $this;
    // }

    // public function removeRent(Rent $rent): static
    // {
    //     if ($this->rents->removeElement($rent)) {
    //         // set the owning side to null (unless already changed)
    //         if ($rent->getLenderUser() === $this) {
    //             $rent->setLenderUser(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getCourse(): ?string
    {
        return $this->course;
    }

    public function setCourse(string $course): static
    {
        $this->course = $course;

        return $this;
    }

    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    public function setInstitution(string $institution): static
    {
        $this->institution = $institution;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->username;
    }

    public function setFullName(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    // /**
    //  * @return Collection<int, Book>
    //  */
    // public function getBooks(): Collection
    // {
    //     return $this->books;
    // }

    // public function addBook(Book $book): static
    // {
    //     if (!$this->books->contains($book)) {
    //         $this->books->add($book);
    //         $book->setCreatedBy($this);
    //     }

    //     return $this;
    // }

    // public function removeBook(Book $book): static
    // {
    //     if ($this->books->removeElement($book)) {
    //         // set the owning side to null (unless already changed)
    //         if ($book->getCreatedBy() === $this) {
    //             $book->setCreatedBy(null);
    //         }
    //     }

    //     return $this;
    // }
}
