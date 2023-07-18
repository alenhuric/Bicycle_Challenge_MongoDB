<?php

namespace App\Tests;

use App\Kernel;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    public function testKernelInstance()
    {
        $kernel = new Kernel('test', true);

        $this->assertInstanceOf(Kernel::class, $kernel);
    }
}
