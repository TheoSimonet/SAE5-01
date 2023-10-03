<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $libs = [['travaux pratiques', 'TP'], ['travaux dirigés', 'TD'], ['cours magistraux', 'CM']];

        foreach ($libs as $lib) {
            $group = new Group();
            $group->setLib($lib[0]);
            $group->setType($lib[1]);

            $manager->persist($group);
        }

        $manager->flush();
    }
}
