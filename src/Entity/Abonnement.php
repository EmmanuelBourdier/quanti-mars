<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
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
    private ?int $duration = null;
    

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * @var Collection<int, UserAbonnement>
     */
    #[ORM\OneToMany(targetEntity: UserAbonnement::class, mappedBy: 'abonnement')]
    private Collection $userAbonnements;

    public function __construct()
    {
        $this->userAbonnements = new ArrayCollection();
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }


    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, UserAbonnement>
     */
    public function getUserAbonnements(): Collection
    {
        return $this->userAbonnements;
    }

    public function addUserAbonnement(UserAbonnement $userAbonnement): static
    {
        if (!$this->userAbonnements->contains($userAbonnement)) {
            $this->userAbonnements->add($userAbonnement);
            $userAbonnement->setAbonnement($this);
        }

        return $this;
    }

    public function removeUserAbonnement(UserAbonnement $userAbonnement): static
    {
        if ($this->userAbonnements->removeElement($userAbonnement)) {
            // set the owning side to null (unless already changed)
            if ($userAbonnement->getAbonnement() === $this) {
                $userAbonnement->setAbonnement(null);
            }
        }

        return $this;
    }
}
