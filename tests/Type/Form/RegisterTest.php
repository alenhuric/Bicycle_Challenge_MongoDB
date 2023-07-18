<?php

namespace App\Tests\Type\Form;

use App\Document\User;
use Symfony\Component\Form\Test\TypeTestCase;
use App\Type\Form\Register;
use Symfony\Component\Validator\Constraints\Length;

class RegisterTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        $objectToCompare = new User();
        $form = $this->factory->create(Register::class, $objectToCompare);

        $object = new User();
        $object->setName($formData['name']);
        $object->setEmail($formData['email']);
        $object->setPassword($formData['password']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $objectToCompare);
        $this->assertInstanceOf(User::class, $form->getData());
        $this->assertEmpty($form->getErrors());
    }

    public function testPasswordLengthValidation()
    {
        $formData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'pass', // Password length less than 6 characters
        ];

        $objectToCompare = new User();
        $form = $this->factory->create(Register::class, $objectToCompare);

        $form->submit($formData);

        $this->assertFalse($form->isSynchronized());
        $this->assertContains('This value is too short. It should have 6 characters or more.', $form->get('password')->getErrors(true));
    }

    public function testConstraints()
    {
        $formData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        $objectToCompare = new User();
        $form = $this->factory->create(Register::class, $objectToCompare);

        $form->add('password', RepeatedType::class, [
            'type' => TextType::class,
            'constraints' => [
                new Length(['min' => 6]),
            ],
        ]);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $objectToCompare);
        $this->assertInstanceOf(User::class, $form->getData());
        $this->assertEmpty($form->getErrors());
    }
}
