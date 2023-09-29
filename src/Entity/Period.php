<?php
namespace App\Entity;

use App\Repository\PeriodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodRepository::class)]
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

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $weekStart = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $weekEnd = null;

    /**
     * @var Collection|Semester[]
     */
    #[ORM\ManyToMany(targetEntity: Semester::class, mappedBy: 'periods')]
    private $semesters;

    public function __construct()
    {
        $this->semesters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    #[ORM\PrePersist]
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    #[ORM\PrePersist]
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getWeekStart(): ?\DateTimeInterface
    {
        return $this->weekStart;
    }

    #[ORM\PrePersist]
    public function setWeekStart(\DateTimeInterface $weekStart): self
    {
        $this->weekStart = $weekStart;

        return $this;
    }

    public function getWeekEnd(): ?\DateTimeInterface
    {
        return $this->weekEnd;
    }

    #[ORM\PrePersist]
    public function setWeekEnd(\DateTimeInterface $weekEnd): self
    {
        $this->weekEnd = $weekEnd;

        return $this;
    }

    /**
     * @return Collection|Semester[]
     */
    public function getSemesters(): Collection
    {
        return $this->semesters;
    }

}

