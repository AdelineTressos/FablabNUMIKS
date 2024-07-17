<?php

namespace App\Entity;

use App\Repository\PersonsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorMap(["persons" => Persons::class, "users" => Users::class])]
#[ORM\Entity(repositoryClass: PersonsRepository::class)]

class Persons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    private ?string $phone = null;

    #[ORM\Column(length: 150)]
    private ?string $email = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genders $gender = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalCode $postalcode = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cities $city = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_visitor = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
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

    public function getGender(): ?Genders
    {
        return $this->gender;
    }

    public function setGender(?Genders $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPostalcode(): ?PostalCode
    {
        return $this->postalcode;
    }

    public function setPostalcode(?PostalCode $postalcode): static
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function isIsVisitor(): ?bool
    {
        return $this->is_visitor;
    }

    public function setIsVisitor(?bool $is_visitor): static
    {
        $this->is_visitor = $is_visitor;

        return $this;
    } 

}