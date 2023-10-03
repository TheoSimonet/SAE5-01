<?php

namespace App\DataFixtures;

use App\Factory\SemesterFactory;
use App\Factory\SubjectFactory;
use App\Repository\SemesterRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public SemesterRepository $repository;
    public function __construct(SemesterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function load(ObjectManager $manager): void
    {
        $subject= file_get_contents(__DIR__ . '/data/subject.json',true);
        $subjects = json_decode($subject,true);

        $semesterRepository = $this->repository;


        foreach($subjects as $elmt)
        {
            SubjectFactory::createOne([
                'name' => $elmt['name'],
                'firstWeek' => new \DateTime($elmt['firstWeek']),
                'lastWeek' => new \DateTime($elmt['lastWeek']),
                'hoursTotal' => $elmt['hoursTotal'],
                'subjectCode' => $elmt['subjectCode'],
                'semester' => $semesterRepository->find($elmt['semester'])
            ]);
        }
    }
}
