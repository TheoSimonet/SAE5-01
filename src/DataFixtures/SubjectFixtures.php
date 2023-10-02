<?php

namespace App\DataFixtures;

use App\Factory\SubjectFactory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SubjectFactory::createOne(['name' => 'Maths', 'firstWeek' => new DateTime('2021-09-06'), 'lastWeek' => new DateTime('2021-12-17'), 'hoursTotal' => 60,'subjectCode' => 'MR205']);
        SubjectFactory::createOne(['name' => 'Anglais', 'firstWeek' => new DateTime('2021-05-03'), 'lastWeek' => new DateTime('2021-12-21'), 'hoursTotal' => 40,'subjectCode' => 'MR208']);
        SubjectFactory::createOne(['name' => 'Communication', 'firstWeek' => new DateTime('2021-02-06'), 'lastWeek' => new DateTime('2021-11-09'), 'hoursTotal' => 50,'subjectCode' => 'MR209']);
        SubjectFactory::createOne(['name' => 'PPP', 'firstWeek' => new DateTime('2021-01-01'), 'lastWeek' => new DateTime('2021-10-08'), 'hoursTotal' => 45,'subjectCode' => 'MR210']);
        SubjectFactory::createOne(['name' => 'Gestion', 'firstWeek' => new DateTime('2021-09-05'), 'lastWeek' => new DateTime('2021-12-16'), 'hoursTotal' => 55,'subjectCode' => 'MR212']);
        SubjectFactory::createOne(['name' => 'Eco', 'firstWeek' => new DateTime('2021-07-09'), 'lastWeek' => new DateTime('2021-12-02'), 'hoursTotal' => 42,'subjectCode' => 'MR213']);

        $manager->flush();

    }
}
