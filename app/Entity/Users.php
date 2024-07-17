<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'Il y a déjà un compte avec ce nom utilisateur !')]
class Users extends Persons implements UserInterface, PasswordAuthenticatedUserInterface
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

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

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $birthday = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $street = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $adress_complement = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_organization = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_email_verified = null;

    #[ORM\Column(type: 'string', length: 100)]
    private $resetToken;

    #[ORM\Column(nullable: true)]
    private ?bool $is_validated = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $first_membership = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $last_membership = null;

    #[ORM\ManyToMany(targetEntity: Consummables::class, cascade: ['persist', 'remove'])]
    private Collection $consummable;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $num_siret = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name_organization = null;

    public function __construct()
    {
        $this->consummable = new ArrayCollection();
    }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTime $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getAdressComplement(): ?string
    {
        return $this->adress_complement;
    }

    public function setAdressComplement(?string $adress_complement): static
    {
        $this->adress_complement = $adress_complement;

        return $this;
    }

    public function isIsOrganization(): ?bool
    {
        return $this->is_organization;
    }

    public function setIsOrganization(?bool $is_organization): static
    {
        $this->is_organization = $is_organization;

        return $this;
    }

    public function isIsEmailVerified(): ?bool
    {
        return $this->is_email_verified;
    }
    

    public function setIsEmailVerified(?bool $is_email_verified): static
    {
        $this->is_email_verified = $is_email_verified;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function isIsValidated(): ?bool
    {
        return $this->is_validated;
    }

    public function setIsValidated(bool $is_validated): static
    {
        $this->is_validated = $is_validated;

        return $this;
    }

    public function getFirstMembership(): ?\DateTime
    {
        return $this->first_membership;
    }

    public function setFirstMembership(?\DateTime $first_membership): static
    {
        $this->first_membership = $first_membership;

        return $this;
    }

    public function getLastMembership(): ?\DateTime
    {
        return $this->last_membership;
    }

    public function setLastMembership(?\DateTime $last_membership): static
    {
        $this->last_membership = $last_membership;

        return $this;
    }

    /**
     * @return Collection<int, Consummables>
     */
    public function getConsummable(): Collection
    {
        return $this->consummable;
    }

    public function addConsummable(Consummables $consummable): static
    {
        if (!$this->consummable->contains($consummable)) {
            $this->consummable->add($consummable);
        }

        return $this;
    }

    public function removeConsummable(Consummables $consummable): static
    {
        $this->consummable->removeElement($consummable);

        return $this;
    }

    public function getNumSiret(): ?string
    {
        return $this->num_siret;
    }

    public function setNumSiret(?string $num_siret): static
    {
        $this->num_siret = $num_siret;

        return $this;
    }

    public function getNameOrganization(): ?string
    {
        return $this->name_organization;
    }

    public function setNameOrganization(?string $name_organization): static
    {
        $this->name_organization = $name_organization;

        return $this;
    }
}