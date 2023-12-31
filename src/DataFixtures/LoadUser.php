<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoadUser extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('test@challenge.com');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));

        $manager->persist($user);
        $manager->flush();

    }
}