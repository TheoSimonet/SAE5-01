<?php

namespace App\DataFixtures;

use App\Entity\Year;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class YearFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $seasons = ['2021-2022', '2022-2023', '2023-2024'];

        foreach ($seasons as $season) {
            $year = new Year();
            $year->setSeason($season);

            $manager->persist($year);
        }

        $manager->flush();
    }
}
