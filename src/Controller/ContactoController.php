<?php

namespace App\Controller;

use App\Entity\Contacto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contacto', name: 'contacto')]
    public function index(Request $request): Response
    {
        $contacto = new Contacto();
        $form = $this->createForm(ContactoType::class, $contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($contacto);
            $this->entityManager->flush();


            $this->addFlash('success', 'Tu mensaje ha sido enviado con éxito.');


            return $this->redirectToRoute('inicio');
        }

        return $this->render('contacto/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
