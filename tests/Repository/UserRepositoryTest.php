<?php

namespace App\Tests\Repository;

use App\Document\User;
use App\Repository\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserRepositoryTest extends TestCase
{
    private $documentManager;
    private $repository;

    protected function setUp(): void
    {
        $this->documentManager = $this->createMock(DocumentManager::class);
        $this->repository = $this->createMock(DocumentRepository::class);
    }

    public function testFindAll(): void
    {
        $user1 = new User();
        $user1->setEmail('user1@example.com');

        $user2 = new User();
        $user2->setEmail('user2@example.com');

        $users = [$user1, $user2];

        $this->repository->expects($this->once())
            ->method('findAll')
            ->willReturn($users);

        $userRepository = new UserRepository($this->documentManager);
        $userRepository->setRepository($this->repository);

        $result = $userRepository->findAll();

        $this->assertEquals($users, $result);
    }

    public function testInsert(): void
    {
        $user = new User();
        $user->setEmail('test@gmail.com');
        $user->setPassword('Password1');

        $this->documentManager->expects($this->once())
            ->method('persist')
            ->with($user);

        $this->documentManager->expects($this->once())
            ->method('flush');

        $userRepository = new UserRepository($this->documentManager);
        $response = $userRepository->insert();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(['Status' => 'OK'], json_decode($response->getContent(), true));
    }
}
