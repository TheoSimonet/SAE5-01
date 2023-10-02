<?php

namespace App\DataFixtures;

use App\Factory\PeriodFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PeriodFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PeriodFactory::new()->createMany(10);
    }
}
