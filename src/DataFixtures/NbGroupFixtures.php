<?php

namespace App\DataFixtures;

use App\Entity\NbGroup;
use App\Repository\GroupRepository;
use App\Repository\SubjectRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @ORMFixture(order=2)
 */
class NbGroupFixtures extends Fixture implements DependentFixtureInterface
{
    private GroupRepository $group;
    private SubjectRepository $subject;

    public function __construct(GroupRepository $group, SubjectRepository $subject)
    {
        $this->group = $group;
        $this->subject = $subject;
    }

    public function load(ObjectManager $manager): void
    {
        $values = [[6, 1, 1], [3, 2, 1], [1, 3, 1]]; // [nombre de groupe, idCategorie, idMatiere]

        foreach ($values as $value) {
            $group = $this->group->find($value[1]);
            $subject = $this->subject->find($value[1]);

            $nbGroup = new NbGroup();
            $nbGroup->setNbGroup($value[0]);
            $nbGroup->addGroupRelation($group);
            $nbGroup->addSubject($subject);

            $manager->persist($group);
            $manager->persist($subject);
            $manager->persist($nbGroup);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SubjectFixtures::class,
        ];
    }


}
