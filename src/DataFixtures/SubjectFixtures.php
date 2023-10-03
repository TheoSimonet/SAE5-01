<?php

namespace App\DataFixtures;

use App\Factory\SubjectFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SubjectFactory::createOne(['name' => 'Maths', 'firstWeek' => 32, 'lastWeek' => 1, 'hoursTotal' => 60, 'subjectCode' => 'MR205']);
        SubjectFactory::createOne(['name' => 'Anglais', 'firstWeek' => 32, 'lastWeek' => 1, 'hoursTotal' => 40, 'subjectCode' => 'MR208']);
        SubjectFactory::createOne(['name' => 'Communication', 'firstWeek' => 32, 'lastWeek' => 1, 'hoursTotal' => 50, 'subjectCode' => 'MR209']);
        SubjectFactory::createOne(['name' => 'PPP', 'firstWeek' => 32, 'lastWeek' => 1, 'hoursTotal' => 45, 'subjectCode' => 'MR210']);
        SubjectFactory::createOne(['name' => 'Gestion', 'firstWeek' => 32, 'lastWeek' => 1, 'hoursTotal' => 55, 'subjectCode' => 'MR212']);
        SubjectFactory::createOne(['name' => 'Eco', 'firstWeek' => 32, 'lastWeek' => 1, 'hoursTotal' => 42, 'subjectCode' => 'MR213']);

        $manager->flush();
    }
}
