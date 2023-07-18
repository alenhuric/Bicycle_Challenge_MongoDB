<?php

namespace App\Tests\DataFixtures;

use App\DataFixtures\LoadUser;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LoadUserTest extends TestCase
{
    public function testLoad()
    {
        // Create a mock ObjectManager
        $objectManager = $this->createMock(ObjectManager::class);
        
        // Create a mock UserPasswordHasherInterface
        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $passwordHasher->expects($this->once())
            ->method('hashPassword')
            ->willReturn('hashed_password'); // Specify the expected hashed password value
        
        // Instantiate the LoadUser fixture class
        $fixture = new LoadUser($passwordHasher);
        
        // Assert that the persist and flush methods are called on the ObjectManager
        $objectManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(User::class)); // Assuming User is the correct entity class
        $objectManager->expects($this->once())
            ->method('flush');
        
        // Call the load method on the fixture
        $fixture->load($objectManager);
        
        // Additional assertions if necessary
    }
}
