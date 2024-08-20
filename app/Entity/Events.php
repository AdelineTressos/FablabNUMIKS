<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventsRepository::class)]
class Events
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name_event = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $start_date = null;

    
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $end_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $start_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $end_hour = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $front_media = null;

    #[ORM\Column(type: "boolean", nullable: true)]
    private ?bool $is_published = null;

    #[ORM\Column]
    private ?bool $is_member_only = null;

    #[ORM\Column(nullable: true)]
    private ?int $max_participants = null;

    public function __construct()
    {
        $this->is_published = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEvent(): ?string
    {
        return $this->name_event;
    }

    public function setNameEvent(string $name_event): static
    {
        $this->name_event = $name_event;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTime $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTime $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getStartHour(): ?\DateTime
    {
        return $this->start_hour;
    }

    public function setStartHour(?string $start_hour): static
    {
    $this->start_hour = $start_hour ? new \DateTime($start_hour) : null;

    return $this;
    }

    public function getEndHour(): ?\DateTime
    {
        return $this->end_hour;
    }

    public function setEndHour(?string $end_hour): static
    {
    $this->end_hour = $end_hour ? new \DateTime($end_hour) : null;

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

    public function getFrontMedia(): ?string
    {
        return $this->front_media;
    }

    public function setFrontMedia(?string $front_media): static
    {
        $this->front_media = $front_media;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->is_published;
    }

    public function setIsPublished(bool $is_published): static
    {
        $this->is_published = $is_published;

        return $this;
    }

    public function isIsMemberOnly(): ?bool
    {
        return $this->is_member_only;
    }

    public function setIsMemberOnly(bool $is_member_only): static
    {
        $this->is_member_only = $is_member_only;

        return $this;
    }

    public function getMaxParticipants(): ?int
    {
        return $this->max_participants;
    }

    public function setMaxParticipants(?int $max_participants): static
    {
        $this->max_participants = $max_participants;

        return $this;
    }
}