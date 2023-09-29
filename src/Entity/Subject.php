<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\SubjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            security: "is_granted('ROLE_ADMIN')",
        ),
        ]
)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $hoursPerWeek = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $firstWeek = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $lastWeek = null;

    #[ORM\Column(length: 25)]
    private ?string $subjectCode = null;

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

    public function getHoursPerWeek(): ?int
    {
        return $this->hoursPerWeek;
    }

    public function setHoursPerWeek(int $hoursPerWeek): static
    {
        $this->hoursPerWeek = $hoursPerWeek;

        return $this;
    }

    public function getFirstWeek(): ?\DateTimeInterface
    {
        return $this->firstWeek;
    }

    public function setFirstWeek(\DateTimeInterface $firstWeek): static
    {
        $this->firstWeek = $firstWeek;

        return $this;
    }

    public function getLastWeek(): ?\DateTimeInterface
    {
        return $this->lastWeek;
    }

    public function setLastWeek(\DateTimeInterface $lastWeek): static
    {
        $this->lastWeek = $lastWeek;

        return $this;
    }

    public function getSubjectCode(): ?string
    {
        return $this->subjectCode;
    }

    public function setSubjectCode(string $subjectCode): static
    {
        $this->subjectCode = $subjectCode;

        return $this;
    }
}
