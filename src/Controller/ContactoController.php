<?php

namespace App\Controller;

use App\Entity\Contacto;
use App\Form\ContactoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            $correo = $form->get('correo')->getData();

            $fechaHoy = new \DateTime();
            $fechaHoy->setTime(0, 0, 0);

            $mensajeExistente = $this->entityManager->getRepository(Contacto::class)
                ->findOneBy([
                    'correo' => $correo,
                    'fechaEnvio' => $fechaHoy
                ]);

            if ($mensajeExistente) {
                $this->addFlash('error', 'Ya has enviado un mensaje hoy.');
            } else {
                $contacto->setFechaEnvio(new \DateTime());
                $this->entityManager->persist($contacto);
                $this->entityManager->flush();

                $this->addFlash('success', 'Tu mensaje ha sido enviado con éxito.');
            }
        }

        return $this->render('contacto/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/api/contacto', name: 'api_contacto', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        try {
            $contacto = $serializer->deserialize($request->getContent(), Contacto::class, 'json');

            $correo = $contacto->getCorreo();
            $fechaActual = new \DateTime();
            $contactoExistente = $this->entityManager->getRepository(Contacto::class)
                ->findOneBy([
                    'correo' => $correo,
                    'fechaEnvio' => $fechaActual
                ]);

            if ($contactoExistente) {
                return $this->json(['error' => 'Solo puedes enviar un mensaje por día.'], Response::HTTP_BAD_REQUEST);
            }


            $errors = $validator->validate($contacto);
            if (count($errors) > 0) {
                return $this->json($errors, Response::HTTP_BAD_REQUEST);
            }

            $entityManager->persist($contacto);
            $entityManager->flush();

            return $this->json($contacto, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
