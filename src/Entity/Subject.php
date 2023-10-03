<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SubjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN') and object.getUser() == user",
        ),
        new Put(
            normalizationContext: ['groups' => ['get_Subject']],
            denormalizationContext: ['groups' => ['set_Subject']],
            security: "is_granted('ROLE_USER') and object == user"
        ),
        new Patch(
            normalizationContext: ['groups' => ['get_Subject']],
            denormalizationContext: ['groups' => ['set_Subject']],
            security: "is_granted('ROLE_USER') and object == user"
        ),
        ]
)]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_Subject'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['get_Subject'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['get_Subject'])]
    private ?int $firstWeek = null;

    #[ORM\Column]
    #[Groups(['get_Subject'])]
    private ?int $lastWeek = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_Subject'])]
    private ?string $subjectCode = null;

    #[ORM\Column]
    #[Groups(['get_Subject'])]
    private ?int $hoursTotal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    #[Groups(['get_Subject', 'set_Subject'])]
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstWeek(): ?int
    {
        return $this->firstWeek;
    }

    #[Groups(['get_Subject', 'set_Subject'])]
    public function setFirstWeek(int $firstWeek): static
    {
        $this->firstWeek = $firstWeek;

        return $this;
    }

    public function getLastWeek(): ?int
    {
        return $this->lastWeek;
    }

    #[Groups(['get_Subject', 'set_Subject'])]
    public function setLastWeek(int $lastWeek): static
    {
        $this->lastWeek = $lastWeek;

        return $this;
    }

    public function getSubjectCode(): ?string
    {
        return $this->subjectCode;
    }

    #[Groups(['get_Subject', 'set_Subject'])]
    public function setSubjectCode(string $subjectCode): static
    {
        $this->subjectCode = $subjectCode;

        return $this;
    }

    public function getHoursTotal(): ?int
    {
        return $this->hoursTotal;
    }

    public function setHoursTotal(int $hoursTotal): static
    {
        $this->hoursTotal = $hoursTotal;

        return $this;
    }
}
