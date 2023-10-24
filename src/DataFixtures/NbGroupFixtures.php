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
        $values = [[6, 1, 1], [3, 2, 1], [0, 3, 1],
                    [7, 1, 2], [4, 2, 2], [2, 3, 2],
                    [6, 1, 3], [3, 2, 3], [1, 3, 3],
                    [6, 1, 4], [3, 2, 4], [1, 3, 4],
                    [6, 1, 5], [3, 2, 5], [1, 3, 5],
                    [6, 1, 6], [3, 2, 6], [1, 3, 6],
                    [6, 1, 7], [3, 2, 7], [1, 3, 7],
                    [6, 1, 8], [3, 2, 8], [1, 3, 8],
                    [6, 1, 9], [3, 2, 9], [1, 3, 9]]; // [nombre de groupe, idCategorie, idMatiere]

        foreach ($values as $value) {
            $group = $this->group->find($value[1]);
            $subject = $this->subject->find($value[2]);

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
