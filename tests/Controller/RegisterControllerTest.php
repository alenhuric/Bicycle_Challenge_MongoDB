<?php

namespace App\Tests\Controller;

use App\Controller\RegisterController;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormInterface;

class RegisterControllerTest extends WebTestCase
{
    private $documentManagerMock;
    private $formFactoryMock;
    private $passwordHasherMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->documentManagerMock = $this->createMock(DocumentManager::class);
        $this->formFactoryMock = $this->createMock(FormFactoryInterface::class);
        $this->passwordHasherMock = $this->createMock(UserPasswordHasherInterface::class);
    }

    public function testRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('Register')->form();
        $form['register[username]'] = 'testuser';
        $form['register[password][first]'] = 'testpassword';
        $form['register[password][second]'] = 'testpassword';

        $client->submit($form);

        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.login-form');
    }
}
