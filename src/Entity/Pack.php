<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PackRepository::class)]
class Pack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $quantity = null;

    /**
     * @var Collection<int, UserPack>
     */
    #[ORM\OneToMany(targetEntity: UserPack::class, mappedBy: 'pack')]
    private Collection $userPacks;

    public function __construct()
    {
        $this->userPacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, UserPack>
     */
    public function getUserPacks(): Collection
    {
        return $this->userPacks;
    }

    public function addUserPack(UserPack $userPack): static
    {
        if (!$this->userPacks->contains($userPack)) {
            $this->userPacks->add($userPack);
            $userPack->setPack($this);
        }

        return $this;
    }

    public function removeUserPack(UserPack $userPack): static
    {
        if ($this->userPacks->removeElement($userPack)) {
            // set the owning side to null (unless already changed)
            if ($userPack->getPack() === $this) {
                $userPack->setPack(null);
            }
        }

        return $this;
    }
}
