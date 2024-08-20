<?php

namespace App\Entity;

use App\Repository\UnitsConsummableRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitsConsummableRepository::class)]
class UnitsConsummable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name_unit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameUnit(): ?string
    {
        return $this->name_unit;
    }

    public function setNameUnit(string $name_unit): static
    {
        $this->name_unit = $name_unit;

        return $this;
    }
}
