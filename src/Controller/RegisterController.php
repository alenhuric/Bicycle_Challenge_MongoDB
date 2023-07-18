<?php

namespace App\Controller;

use App\Type\Form\Register;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Response;


class RegisterController extends AbstractController
{
    private $documentManager;
    private $formFactory;
    private $passwordHasher;

    public function __construct(DocumentManager $documentManager, FormFactoryInterface $formFactory, UserPasswordHasherInterface $passwordHasher)
    {
        $this->documentManager = $documentManager;
        $this->formFactory = $formFactory;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(Register::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword($this->passwordHasher->hashPassword($user, $form->get('password')->getData()));
            $user->setRoles(['ROLE_USER']);
            $this->documentManager->persist($user);
            $this->documentManager->flush();

           return $this->redirectToRoute('app_login');
        }

        return $this->render('register/register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}