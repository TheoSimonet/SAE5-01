<?php

namespace App\DataFixtures;

use App\Factory\AssignmentFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AssignmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AssignmentFactory::createMany(10);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
