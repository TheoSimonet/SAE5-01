<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PeriodRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodRepository::class)]
#[ApiResource]
class Period
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $weekStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $weekEnd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getWeekStart(): ?\DateTimeInterface
    {
        return $this->weekStart;
    }

    public function setWeekStart(\DateTimeInterface $weekStart): static
    {
        $this->weekStart = $weekStart;

        return $this;
    }

    public function getWeekEnd(): ?\DateTimeInterface
    {
        return $this->weekEnd;
    }

    public function setWeekEnd(\DateTimeInterface $weekEnd): static
    {
        $this->weekEnd = $weekEnd;

        return $this;
    }
}
