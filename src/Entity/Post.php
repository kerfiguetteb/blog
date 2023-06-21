<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $introduction = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $visibilite = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: IsLike::class)]
    private Collection $isLikes;

    public function __construct()
    {
        $this->isLikes = new ArrayCollection();
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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): static
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isVisibilite(): ?bool
    {
        return $this->visibilite;
    }

    public function setVisibilite(bool $visibilite): static
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    /**
     * @return Collection<int, IsLike>
     */
    public function getIsLikes(): Collection
    {
        return $this->isLikes;
    }

    public function addIsLike(IsLike $isLike): static
    {
        if (!$this->isLikes->contains($isLike)) {
            $this->isLikes->add($isLike);
            $isLike->setPost($this);
        }

        return $this;
    }

    public function removeIsLike(IsLike $isLike): static
    {
        if ($this->isLikes->removeElement($isLike)) {
            // set the owning side to null (unless already changed)
            if ($isLike->getPost() === $this) {
                $isLike->setPost(null);
            }
        }

        return $this;
    }

}
