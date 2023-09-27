<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $group1 = new Group();
        $group1->setLib('INF-S1-TD1');
        $group1->setType('TD');

        $group2 = new Group();
        $group2->setLib('INF-S1-TD2');
        $group2->setType('TD');

        $manager->persist($group1);
        $manager->persist($group2);

        $manager->flush();
    }
}