<?php

namespace App\Entity;


use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_reservation = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $start_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $end_hour = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_validated = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $state_reservation = null;

    #[ORM\ManyToOne]
    private ?Events $event = null;


    #[ORM\ManyToOne(targetEntity: Workspaces::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workspaces $workspace;

    #[ORM\ManyToOne]
    private ?Machines $machine = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReservation(): ?\DateTime
    {
        return $this->date_reservation;
    }

    public function setDateReservation(\DateTimeInterface $date_reservation): static
    {
        $this->date_reservation = $date_reservation;

        return $this;
    }

    public function getStartHour(): ?\DateTime
    {
        return $this->start_hour;
    }

    public function setStartHour(\DateTime $start_hour): static
    {
        $this->start_hour = $start_hour;

        return $this;
    }

    public function getEndHour(): ?\DateTime
    {
        return $this->end_hour;
    }

    public function setEndHour(\DateTime $end_hour): static
    {
        $this->end_hour = $end_hour;

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

    public function getStateReservation(): ?string
    {
        return $this->state_reservation;
    }

    public function setStateReservation(?string $state_reservation): static
    {
        $this->state_reservation = $state_reservation;

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

    public function getWorkspace(): ?Workspaces
    {
        return $this->workspace;
    }

    public function setWorkspace(?Workspaces $workspace): static
    {
        $this->workspace = $workspace;

        return $this;
    }

    public function getMachine(): ?Machines
    {
        return $this->machine;
    }

    public function setMachine(?Machines $machine): static
    {
        $this->machine = $machine;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    
}
