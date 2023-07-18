<?php

namespace App\Tests\Document;

use App\Document\Bicycle;
use PHPUnit\Framework\TestCase;

class BicycleTest extends TestCase
{
    public function testUpdateSpeed()
    {
        $bicycle = new Bicycle();
        $bicycle->setStatus('Stopped');
        $bicycle->setAccelerateStatus('Deceleration');

        $bicycle->updateSpeed();

        $this->assertEquals(0, $bicycle->getCurrentSpeed());
        $this->assertEquals('Deceleration', $bicycle->getAccelerateStatus());

        $bicycle->setStatus('Running');
        $bicycle->setAccelerateStatus('Accelerate');

        $bicycle->updateSpeed();

        $this->assertEquals(10, $bicycle->getCurrentSpeed());
        $this->assertEquals('Accelerating', $bicycle->getAccelerateStatus());

        $bicycle->setAccelerateStatus('Deceleration');

        $bicycle->updateSpeed();

        $this->assertEquals(5, $bicycle->getCurrentSpeed());
        $this->assertEquals('Deceleration', $bicycle->getAccelerateStatus());
    }
}
