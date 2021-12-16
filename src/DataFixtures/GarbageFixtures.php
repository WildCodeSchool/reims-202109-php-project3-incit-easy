<?php

namespace App\DataFixtures;

use App\Entity\Garbage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GarbageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $number = 500;
        for ($i = 0; $i < $number; $i++) {
            $garbage = new Garbage();
            $garbage->setRecycledWaste(rand(3, 8));
            $garbage->setNonRecycledWaste(rand(1, 6));
            $garbage->setUser($this->getReference("user_0"));
            $manager->persist($garbage);
        }
        for ($i = 0; $i < $number; $i++) {
            $garbage = new Garbage();
            $garbage->setRecycledWaste(rand(3, 8));
            $garbage->setNonRecycledWaste(rand(1, 6));
            $garbage->setUser($this->getReference("user_1"));
            $manager->persist($garbage);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
