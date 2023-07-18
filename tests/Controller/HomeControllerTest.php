<?php

namespace App\Tests\Controller;

use App\Controller\HomeController;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        // Create a mock UserRepository
        $userRepository = $this->createMock(UserRepository::class);

        $controller = new HomeController($userRepository);

        // Call the index() method
        $response = $controller->index();

        // Assert that the response is an instance of Response
        $this->assertInstanceOf(Response::class, $response);

        $this->assertEquals(200, $response->getStatusCode());
    }
}
