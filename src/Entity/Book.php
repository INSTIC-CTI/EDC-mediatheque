<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img_cover;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_at;

    /**
     * @ORM\Column(type="date")
     */
    private $published_at;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_reserved;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_favorite;

    /**
     * @ORM\OneToMany(targetEntity=BookReservation::class, mappedBy="book")
     */
    private $bookReservations;

    /**
     * @ORM\ManyToMany(targetEntity=Type::class, mappedBy="books")
     */
    private $type;

    public function __construct()
    {
        $this->bookReservations = new ArrayCollection();
        $this->type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImgCover(): ?string
    {
        return $this->img_cover;
    }

    public function setImgCover(?string $img_cover): self
    {
        $this->img_cover = $img_cover;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getIsReserved(): ?bool
    {
        return $this->is_reserved;
    }

    public function setIsReserved(bool $is_reserved): self
    {
        $this->is_reserved = $is_reserved;

        return $this;
    }

    public function getIsFavorite(): ?bool
    {
        return $this->is_favorite;
    }

    public function setIsFavorite(bool $is_favorite): self
    {
        $this->is_favorite = $is_favorite;

        return $this;
    }

    /**
     * @return Collection<int, BookReservation>
     */
    public function getBookReservations(): Collection
    {
        return $this->bookReservations;
    }

    public function addBookReservation(BookReservation $bookReservation): self
    {
        if (!$this->bookReservations->contains($bookReservation)) {
            $this->bookReservations[] = $bookReservation;
            $bookReservation->setBook($this);
        }

        return $this;
    }

    public function removeBookReservation(BookReservation $bookReservation): self
    {
        if ($this->bookReservations->removeElement($bookReservation)) {
            // set the owning side to null (unless already changed)
            if ($bookReservation->getBook() === $this) {
                $bookReservation->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Type>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Type $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
            $type->addBook($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->type->removeElement($type)) {
            $type->removeBook($this);
        }

        return $this;
    }
}
