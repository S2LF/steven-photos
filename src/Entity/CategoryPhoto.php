<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategoryPhotoRepository;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation\SortablePosition;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CategoryPhotoRepository::class)]
class CategoryPhoto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoCoverPath = null;

    #[ORM\OneToMany(mappedBy: 'categoryPhoto', targetEntity: Photo::class, cascade: ['remove'])]
    private Collection $photos;

    #[ORM\Column]
    #[SortablePosition]
    private ?int $position = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\Column]
    private ?bool $isRandomImage = null;

    #[ORM\Column(length: 255)]
    private ?string $display = null;


    public function __construct()
    {
        $this->photos = new ArrayCollection();
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

    public function getPhotoCoverPath(): ?string
    {
        // if isRandomImage is true, return a random image from the category
        if ($this->isRandomImage) {
            $photos = $this->getPhotos();
            $randomPhoto = $photos[array_rand($photos->toArray())];
            return $randomPhoto->getPath();
        } else {
            return $this->photoCoverPath;
        }
    }

    public function setPhotoCoverPath(string|null $photoCoverPath): self
    {
        $this->photoCoverPath = $photoCoverPath;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setCategoryPhoto($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getCategoryPhoto() === $this) {
                $photo->setCategoryPhoto(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get the value of deletedAt
     *
     * @return ?\DateTimeInterface
     */
    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * Set the value of deletedAt
     *
     * @param ?\DateTimeInterface $deletedAt
     *
     * @return self
     */
    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function isIsRandomImage(): ?bool
    {
        return $this->isRandomImage;
    }

    public function setIsRandomImage(bool $isRandomImage): self
    {
        $this->isRandomImage = $isRandomImage;

        return $this;
    }

    public function getDisplay(): ?string
    {
        return $this->display;
    }

    public function setDisplay(string $display): self
    {
        $this->display = $display;

        return $this;
    }
}
