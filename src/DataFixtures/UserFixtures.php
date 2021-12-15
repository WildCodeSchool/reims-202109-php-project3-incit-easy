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
        $userOne->setStreet('20 rue de babel');
        $userOne->setZipcode('51100');
        $userOne->setCity('Reims');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $userOne,
            'useronepassword'
        );

        $userOne->setPassword($hashedPassword);
        $manager->persist($userOne);
        $this->addReference("user_0", $userOne);

        // Création d’un utilisateur de type “administrateur”
        $userTwo = new User();
        $userTwo->setUsername('Michel51');
        $userTwo->setEmail('userTwo@mail.com');
        $userTwo->setRoles(['ROLE_USER']);
        $userTwo->setStreet('45 rue de richard');
        $userTwo->setZipcode('51100');
        $userTwo->setCity('Reims');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $userTwo,
            'usertwopassword'
        );

        $userTwo->setPassword($hashedPassword);
        $manager->persist($userTwo);
        $this->addReference("user_1", $userTwo);


        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}