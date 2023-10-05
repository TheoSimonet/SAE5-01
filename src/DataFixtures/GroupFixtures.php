<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $libs = [['TP'], ['TD'],['CM']];

        foreach ($libs as $lib) {
            $group = new Group();
            $group->setType($lib[0]);

            $manager->persist($group);
        }

        $manager->flush();
    }
}
