<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BicycleControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/bike');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Bicycles');
    }

    public function testAddBike()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add-bike');

        $form = $crawler->selectButton('Save')->form();
        $form['add_bicycle[color]'] = 'Red';
        $form['add_bicycle[brand]'] = 'Trek';
        $form['add_bicycle[status]'] = 'Available';

        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/bike'));
    }

    public function testEditBike()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/edit-bike/1');

        $form = $crawler->selectButton('Save')->form();
        $form['add_bicycle[color]'] = 'Blue';
        $form['add_bicycle[brand]'] = 'Giant';
        $form['add_bicycle[status]'] = 'Rented';

        $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/bike'));
    }


    public function testDeleteBike()
    {
        $client = static::createClient();

        $client->request('GET', '/delete-bike/1');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/bike'));
    }
}
