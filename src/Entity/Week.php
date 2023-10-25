<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WeekRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?float $numberHours = null;

    #[ORM\Column]
    private ?int $weekNumber = null;

    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: 'weeks')]
    private Collection $Subject;

    public function __construct()
    {
        $this->Subject = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Subject>
     */
    public function getSubject(): Collection
    {
        return $this->Subject;
    }

    public function addSubject(Subject $subject): static
    {
        if (!$this->Subject->contains($subject)) {
            $this->Subject->add($subject);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): static
    {
        $this->Subject->removeElement($subject);

        return $this;
    }
}
