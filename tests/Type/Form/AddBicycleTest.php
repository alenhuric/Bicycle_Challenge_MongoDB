<?php

namespace App\Tests\Type\Form;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Type\Form\AddBicycle;
use App\Document\Bicycle;
use Symfony\Component\Form\Test\TypeTestCase;

class AddBicycleTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'color' => 'Red',
            'brand' => 'Brand X',
            'status' => 'Active',
            'accelerateStatus' => true,
            'geolocation' => '123.456'
        ];

        $objectToCompare = new Bicycle();
        $form = $this->factory->create(AddBicycle::class, $objectToCompare);

        $object = new Bicycle();
        $object->setColor($formData['color']);
        $object->setBrand($formData['brand']);
        $object->setStatus($formData['status']);
        $object->setAccelerateStatus($formData['accelerateStatus']);
        $object->setGeolocation($formData['geolocation']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $objectToCompare);
        $this->assertInstanceOf(Bicycle::class, $form->getData());
    }
}
