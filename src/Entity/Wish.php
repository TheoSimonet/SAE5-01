<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\WishRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: WishRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['get_Wish']],
        ),
        new GetCollection(),
        new Post(
            security: "is_granted('ROLE_USER')"
        ),
        new Patch(
            normalizationContext: ['groups' => ['get_Wish', 'set_Wish']],
            security: "is_granted('ROLE_USER')"
        ),
        new Put(
            security: "is_granted('ROLE_USER')"
        ),
        new Delete(
            security: "is_granted('ROLE_USER')"
        ),
    ]
)]


class Wish
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_Wish', 'set_Wish'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['get_Wish','set_Wish'])]
    private ?int $chosenGroups = null;

    #[ORM\ManyToOne(inversedBy: 'wishes')]
    private ?Group $groupeType = null;

    #[ORM\ManyToOne(inversedBy: 'wishes')]
    private ?Subject $subjectId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getChosenGroups(): ?int
    {
        return $this->chosenGroups;
    }

    public function setChosenGroups(?int $chosenGroups): static
    {
        $this->chosenGroups = $chosenGroups;

        return $this;
    }

    public function getGroupeType(): ?Group
    {
        return $this->groupeType;
    }

    public function setGroupeType(?Group $groupeType): static
    {
        $this->groupeType = $groupeType;

        return $this;
    }

    public function getSubjectId(): ?Subject
    {
        return $this->subjectId;
    }

    public function setSubjectId(?Subject $subjectId): static
    {
        $this->subjectId = $subjectId;

        return $this;
    }

}
