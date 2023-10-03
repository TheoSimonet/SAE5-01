<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WeekRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeekRepository::class)]
#[ApiResource]
class Week
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numberHours = null;

    #[ORM\Column]
    private ?int $weekNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberHours(): ?int
    {
        return $this->numberHours;
    }

    public function setNumberHours(int $numberHours): static
    {
        $this->numberHours = $numberHours;

        return $this;
    }

    public function getWeekNumber(): ?int
    {
        return $this->weekNumber;
    }

    public function setWeekNumber(int $weekNumber): static
    {
        $this->weekNumber = $weekNumber;

        return $this;
    }
}
