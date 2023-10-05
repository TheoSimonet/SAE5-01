<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Tests\Fixtures\Metadata\Get;
use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            security: "is_granted('ROLE_ADMIN')",
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
            normalizationContext: ['groups' => ['get_Group']],
            denormalizationContext: ['groups' => ['set_Group']],
            security: "is_granted('ROLE_USER') and object == user"
        ),
        new Patch(
            normalizationContext: ['groups' => ['get_Group']],
            denormalizationContext: ['groups' => ['set_Group']],
            security: "is_granted('ROLE_USER') and object == user"
        ),
    ]
)]
#[ORM\Table(name: 'groups')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['group:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['group:read', 'group:write'])]
    private ?string $lib = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['group:read', 'group:write'])]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'groupeType', targetEntity: Wish::class)]
    private Collection $wishes;


    public function __construct()
    {
        $this->wishes = new ArrayCollection();
    }

    #[ORM\ManyToOne(inversedBy: 'groups')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Subject $subject = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLib(): ?string
    {
        return $this->lib;
    }

    #[Groups(['group:write'])]
    public function setLib(string $lib): static
    {
        $this->lib = $lib;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    #[Groups(['group:write'])]
    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
