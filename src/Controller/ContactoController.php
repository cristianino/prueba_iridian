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
            // Obtener el correo electrónico del formulario
            $correo = $form->get('correo')->getData();

            // Obtener la fecha actual sin hora
            $fechaHoy = new \DateTime();
            $fechaHoy->setTime(0, 0, 0);

            // Verificar si ya existe un mensaje de este correo en la fecha actual
            $mensajeExistente = $this->entityManager->getRepository(Contacto::class)
                ->findOneBy([
                    'correo' => $correo,
                    'fechaEnvio' => $fechaHoy
                ]);

            if ($mensajeExistente) {
                // Agregar un mensaje de error si ya se envió un mensaje hoy
                $this->addFlash('error', 'Ya has enviado un mensaje hoy.');
            } else {
                // Si no hay mensajes previos en la fecha actual, procesar el nuevo mensaje
                $contacto->setFechaEnvio(new \DateTime());
                $this->entityManager->persist($contacto);
                $this->entityManager->flush();

                // Redirigir o mostrar un mensaje de éxito
                $this->addFlash('success', 'Tu mensaje ha sido enviado con éxito.');
                return $this->redirectToRoute('inicio');
            }
        }

        return $this->render('contacto/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
