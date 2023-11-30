<?php

namespace App\Controller;

use App\Repository\AreaDeContactoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AreaDeContactoController extends AbstractController
{
    #[Route('/api/areas-de-contacto', name: 'api_areas_de_contacto')]
    public function index(AreaDeContactoRepository $repository): Response
    {
        $areas = $repository->findAll();
        return $this->json($areas);
    }
}
