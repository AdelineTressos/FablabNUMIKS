<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\WorkspacesRepository;
use App\Entity\Reservations;


#[ORM\Entity(repositoryClass: WorkspacesRepository::class)]
class Workspaces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name_workspace = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $member_access = null;

    #[ORM\Column]
    private ?bool $is_booked = null;

    #[ORM\OneToMany(mappedBy: 'workspace', targetEntity: "App\Entity\Machines", cascade: ['remove'])]
    private Collection $machines;
    #[ORM\OneToMany(mappedBy: 'workspace', targetEntity: Reservations::class, cascade: ['remove'])]
    private Collection $reservations;

    public function __construct()
    {
        $this->machines = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name_workspace;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameWorkspace(): ?string
    {
        return $this->name_workspace;
    }

    public function setNameWorkspace(string $name_workspace): self
    {
        $this->name_workspace = $name_workspace;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function isMemberAccess(): ?bool
    {
        return $this->member_access;
    }

    public function setMemberAccess(?bool $member_access): self
    {
        $this->member_access = $member_access;
        return $this;
    }

    public function isIsBooked(): ?bool
    {
        return $this->is_booked;
    }

    public function setIsBooked(bool $is_booked): self
    {
        $this->is_booked = $is_booked;
        return $this;
    }

    /**
     * @return Collection|Machines[]
     */
    public function getMachines(): Collection
    {
        return $this->machines;
    }
    /**
     * @return Collection|Reservations[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }


    // Add any additional methods you might need for managing machines here
}
