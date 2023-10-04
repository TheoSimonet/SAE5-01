<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\NbGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NbGroupRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            normalizationContext: ['groups' => ['get_NbGroup']],
            denormalizationContext: ['groups' => ['set_NbGroup']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            security: "is_granted('ROLE_ADMIN') and object.getUser() == user",
        ),
        new Patch(
            security: "is_granted('ROLE_ADMIN') and object.getUser() == user",
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN') and object.getUser() == user",
        ),
        new Put(
            normalizationContext: ['groups' => ['get_NbGroup']],
            denormalizationContext: ['groups' => ['set_NbGroup']],
            security: "is_granted('ROLE_USER') and object == user"
        ),
        new Patch(
            normalizationContext: ['groups' => ['get_NbGroup']],
            denormalizationContext: ['groups' => ['set_NbGroup']],
            security: "is_granted('ROLE_USER') and object == user"
        ),
    ]
)]
#[ORM\Table(name: 'nbGroups')]
class NbGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbGroup = null;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'nbGroups')]
    private Collection $GroupRelation;

    #[ORM\ManyToMany(targetEntity: Subject::class, inversedBy: 'nbGroups')]
    private Collection $subject;

    public function __construct()
    {
        $this->GroupRelation = new ArrayCollection();
        $this->subject = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbGroup(): ?int
    {
        return $this->nbGroup;
    }

    public function setNbGroup(int $nbGroup): static
    {
        $this->nbGroup = $nbGroup;

        return $this;
    }

    /**
     * @return Collection<int, Group>
     */
    public function getGroupRelation(): Collection
    {
        return $this->GroupRelation;
    }

    public function addGroupRelation(Group $groupRelation): static
    {
        if (!$this->GroupRelation->contains($groupRelation)) {
            $this->GroupRelation->add($groupRelation);
        }

        return $this;
    }

    public function removeGroupRelation(Group $groupRelation): static
    {
        $this->GroupRelation->removeElement($groupRelation);

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
        }

        return $this;
    }

    public function removeSubject(Subject $subject): static
    {
        $this->subject->removeElement($subject);

        return $this;
    }
}
