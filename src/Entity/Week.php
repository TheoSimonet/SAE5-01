<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WeekRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: WeekRepository::class)]
#[UniqueEntity(fields: ['weekNumber', 'numberHours'], message: 'Cette semaine existe déjà')]
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
    private Collection $subject;

    public function __construct()
    {
        $this->subject = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberHours(): ?float
    {
        return $this->numberHours;
    }

    public function setNumberHours(float $numberHours): static
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
        return $this->subject;
    }

    public function addSubject(Subject $subject): static
    {
        if (!$this->subject->contains($subject)) {
            $this->subject->add($subject);
            $subject->addWeek($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): static
    {
        $this->subject->removeElement($subject);

        return $this;
    }

    public function addSubjectWeek(Subject $subject): static
    {
        if (!$this->subject->contains($subject)) {
            $this->subject->add($subject);
        }

        return $this;
    }
}
