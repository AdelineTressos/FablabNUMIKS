<?php

namespace App\Entity;

use App\Repository\ConsummablesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsummablesRepository::class)]
class Consummables
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name_consummable = null;

    #[ORM\Column(nullable: true)]
    private ?float $quantity = null;

    #[ORM\Column(nullable: true)]
    private ?float $threshold = null;

    #[ORM\ManyToOne]
    private ?CatConsummables $cat_consummables = null;

    #[ORM\ManyToOne]
    private ?UnitsConsummable $unit_consummables = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameConsummable(): ?string
    {
        return $this->name_consummable;
    }

    public function setNameConsummable(string $name_consummable): static
    {
        $this->name_consummable = $name_consummable;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getThreshold(): ?float
    {
        return $this->threshold;
    }

    public function setThreshold(?float $threshold): static
    {
        $this->threshold = $threshold;

        return $this;
    }

    public function getCatConsummables(): ?CatConsummables
    {
        return $this->cat_consummables;
    }

    public function setCatConsummables(?CatConsummables $cat_consummables): static
    {
        $this->cat_consummables = $cat_consummables;

        return $this;
    }

    public function getUnitConsummables(): ?UnitsConsummable
    {
        return $this->unit_consummables;
    }

    public function setUnitConsummables(?UnitsConsummable $unit_consummables): static
    {
        $this->unit_consummables = $unit_consummables;

        return $this;
    }

}
