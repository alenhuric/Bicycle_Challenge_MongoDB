<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetUserIdentifier(): void
    {
        $user = new User();
        $email = 'test@example.com';
        $user->setEmail($email);

        $expectedIdentifier = $email;
        $actualIdentifier = $user->getUserIdentifier();

        $this->assertEquals($expectedIdentifier, $actualIdentifier);
    }

    public function testGetRoles(): void
    {
        $user = new User();
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $user->setRoles($roles);

        $expectedRoles = ['ROLE_ADMIN', 'ROLE_USER'];
        $actualRoles = $user->getRoles();

        $this->assertEquals($expectedRoles, $actualRoles);
    }

    public function testGetPassword(): void
    {
        $user = new User();
        $password = 'password123';
        $user->setPassword($password);

        $expectedPassword = $password;
        $actualPassword = $user->getPassword();

        $this->assertEquals($expectedPassword, $actualPassword);
    }
}
