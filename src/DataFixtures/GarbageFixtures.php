<?php

namespace App\DataFixtures;

use App\Entity\Garbage;
use App\Service\GarbageManager;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GarbageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $garbageManager = new GarbageManager();
        preg_match_all(
            "/([a-zA-Z0-9 ]+),([0-9]+\/[0-9]+\/[0-9]+),(recycled|nonRecycled),([0-9]+\.[0-9]+),,/m",
            $garbageManager->getDataSample(),
            $matches
        );
        for ($i = 0; $i < count($matches[1]); $i++) {
            $garbage = new Garbage();
            $garbage->setCreatedAt(new DateTimeImmutable($matches[2][$i]));
            $garbage->setType($matches[3][$i]);
            $garbage->setWeight($matches[4][$i]);
            $address = $this->getReference($matches[1][$i]);
            $garbage->setAddress($address);
            $manager->persist($garbage);
            if ($i % 400 === 0) {
                $manager->flush();
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            AddressFixtures::class
        ];
    }
}
