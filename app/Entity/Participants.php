<?php

namespace App\Entity;

use App\Repository\ParticipantsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipantsRepository::class)]
class Participants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_validated = null;

    #[ORM\ManyToOne]
    private ?Events $event = null;

    #[ORM\ManyToOne]
    private ?Persons $person = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsValidated(): ?bool
    {
        return $this->is_validated;
    }

    public function setIsValidated(?bool $is_validated): static
    {
        $this->is_validated = $is_validated;

        return $this;
    }

    public function getEvent(): ?Events
    {
        return $this->event;
    }

    public function setEvent(?Events $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getPerson(): ?Persons
    {
        return $this->person;
    }

    public function setPerson(?Persons $person): static
    {
        $this->person = $person;

        return $this;
    }
}
