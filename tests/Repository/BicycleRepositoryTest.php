<?php

namespace App\Tests\Repository;

use App\Document\Bicycle;
use App\Repository\BicycleRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPUnit\Framework\TestCase;

class BicycleRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $documentManager = $this->createMock(DocumentManager::class);
        
        $documentRepository = $this->createMock(DocumentRepository::class);
        
        $expectedBicycles = [
            new Bicycle(),
            new Bicycle(),
            new Bicycle(),
        ];
        $documentRepository->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedBicycles);
        
        $documentManager->expects($this->once())
            ->method('getRepository')
            ->with(Bicycle::class)
            ->willReturn($documentRepository);
        
        $repository = new BicycleRepository($documentManager);
        
        $result = $repository->findAll();
        $this->assertEquals($expectedBicycles, $result);
    }
}
