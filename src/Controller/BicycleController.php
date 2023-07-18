<?php

namespace App\Controller;

use App\Type\Form\AddBicycle;
use App\Document\Bicycle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BicycleRepository;
use Exception;

class BicycleController extends AbstractController
{

    private $documentManager;
    private $formFactory;
    private $bicycleRepository;
    private $doctrine;
    public function __construct(DocumentManager $documentManager, FormFactoryInterface $formFactory, BicycleRepository $bicycleRepository, ManagerRegistry $doctrine)
    {
        $this->documentManager = $documentManager;
        $this->formFactory = $formFactory;
        $this->bicycleRepository = $bicycleRepository;
    }
    /**
     * @Route("/bike", name="bicycle")
     */
    public function index(Request $request): Response
    {
        try {
            $data = $this->bicycleRepository->findAll();
            return $this->render('bicycle/index.html.twig', [
                'bicycles' => $data,
            ]);
        }
        //catch exception
        catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
    /**
     * @Route("/add-bike", name="bicycle_add")
     */

    public function getStoreForm(Request $request): Response
    {
        try {
            $data = $request->request->all();
            $bicycle = new Bicycle();
            $form = $this->createForm(AddBicycle::class, $bicycle);
            $form->handleRequest($request);
            $accelerateStatus = isset($data['accelerateStatus']) ? $data['accelerateStatus'] : "Decleration";
            if ($form->isSubmitted() && $form->isValid()) {
                $bicycle->setStatus($data['status']);
                $bicycle->setAccelerateStatus($accelerateStatus);
                $bicycle->updateSpeed();
                $this->documentManager->persist($bicycle);
                $this->documentManager->flush();
                return $this->redirectToRoute('bicycle');
            }

            return $this->render('bicycle/add.html.twig', [
                'form' => $form->createView()
            ]);
        }
        //catch exception
        catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }


    /**
     * @Route("/edit-bike/{id}", name="bicycle_update")
     */
    public function getUpdateForm(Request $request, $id): Response
    {
        try {
            $data = $this->documentManager->find(Bicycle::class, $id);
            return $this->render('bicycle/edit.html.twig', [
                'bicycle' => $data
            ]);
        }
        //catch exception
        catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
    /**
     * @Route("/edit-bicycle", name="bicycle_update_data")
     */
    public function edit(Request $request): Response
    {
        try {
            $data = $request->request->all();
            $bicycle = $this->documentManager->find(Bicycle::class, $data['id']);
            $form = $this->createForm(AddBicycle::class, $bicycle);
            $form->handleRequest($request);
            $accelerateStatus = isset($data['accelerateStatus']) ? $data['accelerateStatus'] : "Decleration";
            $bicycle->setColor($data['color']);
            $bicycle->setBrand($data['brand']);
            $bicycle->setStatus($data['status']);
            $bicycle->setGeolocation($data['geolocation']);
            $bicycle->setAccelerateStatus($accelerateStatus);
            $bicycle->updateSpeed();
            $this->documentManager->persist($bicycle);
            $this->documentManager->flush();

            return $this->redirectToRoute('bicycle');
        }
        //catch exception
        catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
    /**
     * @Route("/show/{id}", name="bicycle_show")
     */
    public function showBicycle($id): Response
    {
        try {
            $bicycle = $this->documentManager->find(Bicycle::class, $id);
            return $this->render('bicycle/show.html.twig',[
                'bicycle' => $bicycle
            ]);
        }
        //catch exception
        catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    /**
     * @Route("/delete-bike/{id}", name="bicycle_delete")
     */
    public function deleteBicycle($id): Response
    {
        try {
            $bicycle = $this->documentManager->find(Bicycle::class, $id);
            $this->documentManager->remove($bicycle);
            $this->documentManager->flush();
            return $this->redirectToRoute('bicycle');
        }
        //catch exception
        catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
}
