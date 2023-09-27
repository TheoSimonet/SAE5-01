<?php

namespace App\DataFixtures;

use App\Factory\SubjectFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SubjectFactory::createMany(25);

        $manager->flush();

    }
}
