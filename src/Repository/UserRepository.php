<?php

namespace App\Repository;

use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserRepository
{
    private $documentManager;
    private $repository;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
        $this->repository = $documentManager->getRepository(User::class);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }


    public function insert()
    {
        $user = new User();
        $user->setEmail("test@gmail.com");
        $user->setPassword("Password1");

        $this->documentManager->persist($user);
        $this->documentManager->flush();
        return new JsonResponse(array('Status' => 'OK'));
    }

}
