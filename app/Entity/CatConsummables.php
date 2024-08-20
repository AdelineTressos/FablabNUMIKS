<?php

namespace App\Entity;

use App\Repository\CatConsummablesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatConsummablesRepository::class)]
class CatConsummables
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name_category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCategory(): ?string
    {
        return $this->name_category;
    }

    public function setNameCategory(?string $name_category): static
    {
        $this->name_category = $name_category;

        return $this;
    }
}
