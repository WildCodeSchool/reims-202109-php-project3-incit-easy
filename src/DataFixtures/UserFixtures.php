<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $userOne = new User();
        $userOne->setUsername('Romain38');
        $userOne->setEmail('userone@mail.com');
        $userOne->setRoles(['ROLE_USER']);
        $userOne->setNbHousehold('4');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $userOne,
            'useronepassword'
        );

        $userOne->setPassword($hashedPassword);
        $userOne->setAddress($this->getReference("6 AVENUE DE LAON 51100 REIMS"));
        $manager->persist($userOne);
        $this->addReference("user_0", $userOne);

        // Création d’un utilisateur de type “administrateur”
        $userTwo = new User();
        $userTwo->setUsername('Michel51');
        $userTwo->setEmail('userTwo@mail.com');
        $userTwo->setRoles(['ROLE_ADMIN']);
        $userTwo->setNbHousehold('4');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $userTwo,
            'usertwopassword'
        );

        $userTwo->setPassword($hashedPassword);
        $userTwo->setAddress($this->getReference("37 RUE BOUDET 51100 REIMS"));
        $manager->persist($userTwo);
        $this->addReference("user_1", $userTwo);


        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AddressFixtures::class
        ];
    }
}
