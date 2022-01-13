<?php

namespace App\DataFixtures;

use App\Entity\Adress;
use App\Service\GarbageManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdressFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $garbageManager = new GarbageManager();
        preg_match_all("/(.+)\ (.+)\ ([^,]+),.+/m", $garbageManager->getDataSample(), $matches);
        $adresses = [];
        for ($i = 0; $i < count($matches[1]); $i++) {
            $adresses[] = [
                $matches[1][$i],
                $matches[2][$i],
                $matches[3][$i]
            ];
        }
        $adresses = array_unique($adresses, SORT_REGULAR);
        $adresses = array_values($adresses);
        foreach ($adresses as $uniqueAdress) {
            $adress = new Adress();
            $adress->setStreet($uniqueAdress[0]);
            $adress->setZipcode($uniqueAdress[1]);
            $adress->setCity($uniqueAdress[2]);
            $manager->persist($adress);
            $this->addReference($adress->__toString(), $adress);
            if ($i % 100 === 0) {
                $manager->flush();
            }
        }
        $manager->flush();
    }
}
