<?php

namespace App\Repository;

use App\Document\Bicycle;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class BicycleRepository
{
    private $documentManager;
    private $repository;

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
        $this->repository = $documentManager->getRepository(Bicycle::class);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }
   
}
