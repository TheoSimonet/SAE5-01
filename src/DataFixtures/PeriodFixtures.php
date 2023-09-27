<?php

namespace App\DataFixtures;

use App\Entity\Period;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PeriodFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $period1 = new Period();
        $period1->setName('Période 1');
        $period1->setDescription('Description de la période 1');
        $period1->setWeekStart(new \DateTime('2023-10-01'));
        $period1->setWeekEnd(new \DateTime('2023-10-15'));
        $manager->persist($period1);

        $period2 = new Period();
        $period2->setName('Période 2');
        $period2->setDescription('Description de la période 2');
        $period2->setWeekStart(new \DateTime('2023-10-16'));
        $period2->setWeekEnd(new \DateTime('2023-10-31'));
        $manager->persist($period2);

        $manager->flush();
    }
}
