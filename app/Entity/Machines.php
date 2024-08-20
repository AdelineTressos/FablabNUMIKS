<?php

namespace App\Entity;

use App\Repository\MachinesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MachinesRepository::class)]
class Machines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name_machine = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $number_machine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $machine_picture = null;

    #[ORM\Column(nullable: true)]
    private ?bool $member_access = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_booked = null;

    #[ORM\ManyToOne(targetEntity: Workspaces::class, inversedBy: "machines")]
    private ?Workspaces $workspace = null;
    
    #[ORM\OneToMany(mappedBy: "machine", targetEntity: "App\Entity\Reservations", cascade: ['persist', 'remove'])]
    private Collection $reservations;

    public function __toString()
    {
        return $this->name_machine;
    }

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    /**
     * @return Collection|Reservations[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setMachine($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getMachine() === $this) {
                $reservation->setMachine(null);
            }
        }

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMachine(): ?string
    {
        return $this->name_machine;
    }

    public function setNameMachine(string $name_machine): static
    {
        $this->name_machine = $name_machine;

        return $this;
    }

    public function getNumberMachine(): ?string
    {
        return $this->number_machine;
    }

    public function setNumberMachine(?string $number_machine): static
    {
        $this->number_machine = $number_machine;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMachinePicture(): ?string
    {
        return $this->machine_picture;
    }

    public function setMachinePicture(?string $machine_picture): static
    {
        $this->machine_picture = $machine_picture;

        return $this;
    }

    public function isMemberAccess(): ?bool
    {
        return $this->member_access;
    }

    public function setMemberAccess(?bool $member_access): static
    {
        $this->member_access = $member_access;

        return $this;
    }

    public function isIsBooked(): ?bool
    {
        return $this->is_booked;
    }

    public function setIsBooked(?bool $is_booked): static
    {
        $this->is_booked = $is_booked;

        return $this;
    }

    public function getWorkspace(): ?Workspaces
    {
        return $this->workspace;
    }

    public function setWorkspace(?Workspaces $workspace): static
    {
        $this->workspace = $workspace;

        return $this;
    }
}
