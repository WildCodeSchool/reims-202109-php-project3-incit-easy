<?php

namespace App\DataFixtures;

use App\Entity\Garbage;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GarbageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $number = 500;
        $today = new DateTimeImmutable();
        for ($i = 0; $i < $number; $i++) {
            $garbage = new Garbage();
            $garbage->setType(rand(0,1)?'recycled':'nonRecycled');
            $garbage->setWeight(rand(1, 6));
            $garbage->setUser($this->getReference("user_0"));
            $garbage->setCreatedAt($today->modify("-$i week"));
            $manager->persist($garbage);
        }
        for ($i = 0; $i < $number; $i++) {
            $garbage = new Garbage();
            $garbage->setType(rand(0,1)?'recycled':'nonRecycled');
            $garbage->setWeight(rand(1, 6));
            $garbage->setUser($this->getReference("user_1"));
            $garbage->setCreatedAt($today->modify("-$i week"));
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
