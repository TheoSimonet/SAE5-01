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
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['get_Subject']],
        ),
        new Get(
            normalizationContext: ['groups' => ['get_Subject']],
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
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?int $firstWeek = null;

    #[ORM\Column]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?int $lastWeek = null;

    #[ORM\Column(length: 40)]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?string $subjectCode = null;

    #[ORM\ManyToOne(inversedBy: 'subjects')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['get_Subject', 'get_Semester'])]
    private ?Semester $semester = null;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: Group::class, cascade: ['remove'])]
    private Collection $groups;

    #[ORM\ManyToMany(targetEntity: Week::class, mappedBy: 'subject')]
    private Collection $weeks;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->weeks = new ArrayCollection();
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
     * @return Collection<int, Group>
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): static
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->setSubject($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): static
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getSubject() === $this) {
                $group->setSubject(null);
            }
        }

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
}
