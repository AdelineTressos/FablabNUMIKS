<?php

namespace App\Entity;

use App\Repository\CitiesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CitiesRepository::class)]
class Cities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name_city = null;

    public function __toString()
    {
        return $this->name_city;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCity(): ?string
    {
        return $this->name_city;
    }

    public function setNameCity(string $name_city): static
    {
        $this->name_city = $name_city;

        return $this;
    }
}
