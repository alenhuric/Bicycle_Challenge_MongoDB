<?php

namespace App\Tests\DataFixtures;

use App\DataFixtures\AppFixtures;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppFixturesTest extends KernelTestCase
{
    private ?ObjectManager $objectManager;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->objectManager = self::$container->get(ObjectManager::class);
    }

    public function testLoad(): void
    {
        $fixtures = new AppFixtures();
        $fixtures->load($this->objectManager);

        $this->assertTrue(true);
    }
}
