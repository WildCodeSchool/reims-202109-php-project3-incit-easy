<?php

namespace App\DataFixtures;

use App\Entity\Garbage;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GarbageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $number = 5;
        for ($i = 0; $i < $number; $i++) {
            $garbage = new Garbage();
            $garbage->setRecycledWaste($i);
            $garbage->setNonRecycledWaste($i + (rand(1, 5)));
            $garbage->setCreatedAt(new DateTimeImmutable());
            $manager->persist($garbage);
        }
        $manager->flush();
    }
}
