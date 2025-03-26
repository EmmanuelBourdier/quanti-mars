<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    /**
     * @var Collection<int, UserPack>
     */
    #[ORM\OneToMany(targetEntity: UserPack::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $userPacks;

    /**
     * @var Collection<int, UserAbonnement>
     */
    #[ORM\OneToMany(targetEntity: UserAbonnement::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $userAbonnements;

    public function __construct()
    {
        $this->userPacks = new ArrayCollection();
        $this->userAbonnements = new ArrayCollection();
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
    public function getPassword(): string
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

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
            $userPack->setUser($this);
        }

        return $this;
    }

    public function removeUserPack(UserPack $userPack): static
    {
        if ($this->userPacks->removeElement($userPack)) {
            // set the owning side to null (unless already changed)
            if ($userPack->getUser() === $this) {
                $userPack->setUser(null);
            }
        }

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
            $userAbonnement->setUser($this);
        }

        return $this;
    }

    public function removeUserAbonnement(UserAbonnement $userAbonnement): static
    {
        if ($this->userAbonnements->removeElement($userAbonnement)) {
            // set the owning side to null (unless already changed)
            if ($userAbonnement->getUser() === $this) {
                $userAbonnement->setUser(null);
            }
        }

        return $this;
    }
}
