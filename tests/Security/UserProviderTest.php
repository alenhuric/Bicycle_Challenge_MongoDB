<?php

namespace App\Tests\Security;

use App\Document\User;
use App\Security\UserProvider;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProviderTest extends TestCase
{
    public function testLoadUserByUsername(): void
    {
        $username = 'test@example.com';
        $user = new User();
        $user->setEmail($username);
        
        $repository = $this->createMock(DocumentRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => $username])
            ->willReturn($user);
        
        $documentManager = $this->createMock(DocumentManager::class);
        $documentManager->expects($this->once())
            ->method('getRepository')
            ->with(User::class)
            ->willReturn($repository);
        
        $userProvider = new UserProvider($documentManager);
        
        $loadedUser = $userProvider->loadUserByUsername($username);
        
        $this->assertSame($user, $loadedUser);
    }

    public function testLoadUserByUsernameNotFound(): void
    {
        $username = 'nonexistent@example.com';
        
        $repository = $this->createMock(DocumentRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => $username])
            ->willReturn(null);
        
        $documentManager = $this->createMock(DocumentManager::class);
        $documentManager->expects($this->once())
            ->method('getRepository')
            ->with(User::class)
            ->willReturn($repository);
        
        $userProvider = new UserProvider($documentManager);
        
        $this->expectException(UsernameNotFoundException::class);
        $userProvider->loadUserByUsername($username);
    }

    public function testRefreshUser(): void
    {
        $username = 'test@example.com';
        $user = new User();
        $user->setEmail($username);
        
        $repository = $this->createMock(DocumentRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => $username])
            ->willReturn($user);
        
        $documentManager = $this->createMock(DocumentManager::class);
        $documentManager->expects($this->once())
            ->method('getRepository')
            ->with(User::class)
            ->willReturn($repository);
        
        $userProvider = new UserProvider($documentManager);
        
        $refreshedUser = $userProvider->refreshUser($user);
        
        $this->assertSame($user, $refreshedUser);
    }

    public function testRefreshUserUnsupportedUser(): void
    {
        $user = $this->createMock(UserInterface::class);
        
        $documentManager = $this->createMock(DocumentManager::class);
        
        $userProvider = new UserProvider($documentManager);
        
        $this->expectException(UnsupportedUserException::class);
        $userProvider->refreshUser($user);
    }

    public function testSupportsClass(): void
    {
        $documentManager = $this->createMock(DocumentManager::class);
        
        $userProvider = new UserProvider($documentManager);
        
        $this->assertTrue($userProvider->supportsClass(User::class));
        $this->assertFalse($userProvider->supportsClass(\stdClass::class));
    }

    public function testLoadUserByIdentifier(): void
    {
        $identifier = 'test@example.com';
        $user = new User();
        $user->setEmail($identifier);
        
        $repository = $this->createMock(DocumentRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => $identifier])
            ->willReturn($user);
        
        $documentManager = $this->createMock(DocumentManager::class);
        $documentManager->expects($this->once())
            ->method('getRepository')
            ->with(User::class)
            ->willReturn($repository);
        
        $userProvider = new UserProvider($documentManager);
        
        $loadedUser = $userProvider->loadUserByIdentifier($identifier);
        
        $this->assertSame($user, $loadedUser);
    }
}
