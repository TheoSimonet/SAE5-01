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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(
            normalizationContext: ['groups' => ['get_Subject','get_Wish']],
        ),
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
    #[Groups(['get_Subject', 'getWish'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['get_Subject', 'get_Semester', 'getWish'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?\DateTimeInterface $firstWeek = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?\DateTimeInterface $lastWeek = null;

    #[ORM\Column(length: 25)]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?string $subjectCode = null;

    #[ORM\Column]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?int $hoursTotal = null;

    #[ORM\ManyToOne(inversedBy: 'subject')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['get_User', 'set_User'])]
    private ?Semester $semester = null;

    #[ORM\ManyToMany(targetEntity: Week::class, mappedBy: 'Subject')]
    private Collection $weeks;

    #[ORM\OneToMany(mappedBy: 'subjectId', targetEntity: Wish::class)]
    private Collection $wishes;

    public function __construct()
    {
        $this->weeks = new ArrayCollection();
        $this->wishes = new ArrayCollection();
    }

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

    public function getFirstWeek(): ?\DateTimeInterface
    {
        return $this->firstWeek;
    }

    #[Groups(['get_Subject', 'set_Subject'])]
    public function setFirstWeek(\DateTimeInterface $firstWeek): static
    {
        $this->firstWeek = $firstWeek;

        return $this;
    }

    public function getLastWeek(): ?\DateTimeInterface
    {
        return $this->lastWeek;
    }

    #[Groups(['get_Subject', 'set_Subject'])]
    public function setLastWeek(\DateTimeInterface $lastWeek): static
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

    public function getSemester(): ?Semester
    {
        return $this->semester;
    }

    public function setSemester(?Semester $semester): static
    {
        $this->semester = $semester;

        return $this;
    }

    /**
     * @return Collection<int, Week>
     */
    public function getWeeks(): Collection
    {
        return $this->weeks;
    }

    public function addWeek(Week $week): static
    {
        if (!$this->weeks->contains($week)) {
            $this->weeks->add($week);
            $week->addSubject($this);
        }

        return $this;
    }

    public function removeWeek(Week $week): static
    {
        if ($this->weeks->removeElement($week)) {
            $week->removeSubject($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Wish>
     */
    public function getWishes(): Collection
    {
        return $this->wishes;
    }

    public function addWish(Wish $wish): static
    {
        if (!$this->wishes->contains($wish)) {
            $this->wishes->add($wish);
            $wish->setSubjectId($this);
        }

        return $this;
    }

    public function removeWish(Wish $wish): static
    {
        if ($this->wishes->removeElement($wish)) {
            // set the owning side to null (unless already changed)
            if ($wish->getSubjectId() === $this) {
                $wish->setSubjectId(null);
            }
        }

        return $this;
    }
}
