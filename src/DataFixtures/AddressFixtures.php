<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Service\GarbageManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $garbageManager = new GarbageManager();
        preg_match_all("/(.+)\ (.+)\ ([^,]+),.+/m", $garbageManager->getDataSample(), $matches);
        $addresses = [];
        for ($i = 0; $i < count($matches[1]); $i++) {
            $addresses[] = [
                $matches[1][$i],
                $matches[2][$i],
                $matches[3][$i]
            ];
        }
        $addresses = array_unique($addresses, SORT_REGULAR);
        $addresses = array_values($addresses);
        foreach ($addresses as $uniqueAddress) {
            $address = new Address();
            $address->setStreet($uniqueAddress[0]);
            $address->setZipcode($uniqueAddress[1]);
            $address->setCity($uniqueAddress[2]);
            $manager->persist($address);
            $this->addReference($address->__toString(), $address);
            if ($i % 100 === 0) {
                $manager->flush();
            }
        }
        $manager->flush();
    }
}
