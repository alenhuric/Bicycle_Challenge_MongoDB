<?php

namespace App\Tests\Entity;

use App\Entity\Bicycle;
use PHPUnit\Framework\TestCase;

class BicycleTest extends TestCase
{
    public function testUpdateSpeed(): void
    {
        $bicycle = new Bicycle();
        $bicycle->setStatus('Stopped');
        $bicycle->setCurrentSpeed(0);
        $bicycle->setAccelerateStatus('Accelerate');

        $bicycle->updateSpeed();

        $this->assertSame(0, $bicycle->getCurrentSpeed());
        $this->assertSame('Deceleration', $bicycle->getAccelerateStatus());

        $bicycle->setStatus('Moving');
        $bicycle->setCurrentSpeed(20);
        $bicycle->setAccelerateStatus('Accelerate');

        $bicycle->updateSpeed();

        $this->assertSame(30, $bicycle->getCurrentSpeed());
        $this->assertSame('Accelerating', $bicycle->getAccelerateStatus());

        $bicycle->setStatus('Moving');
        $bicycle->setCurrentSpeed(15);
        $bicycle->setAccelerateStatus('Deceleration');

        $bicycle->updateSpeed();

        $this->assertSame(10, $bicycle->getCurrentSpeed());
        $this->assertSame('Deceleration', $bicycle->getAccelerateStatus());
    }
}
