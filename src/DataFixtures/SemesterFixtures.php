<?php

namespace App\DataFixtures;

use App\Factory\SemesterFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SemesterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $semester= file_get_contents(__DIR__ . '/data/semester.json',true);
        $semesters = json_decode($semester,true);

        foreach($semesters as $elmt)
        {
            SemesterFactory::createOne([
                'name' => $elmt['name'],
                'startDate' => new \DateTime($elmt['startDate']),
                'endDate' => new \DateTime($elmt['startDate']),
            ]);
        }
    }
}
