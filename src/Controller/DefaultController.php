<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/default/{id}', name: 'app_default', requirements: ['page' => '\d+'])]
    public function index(int $id): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController', 'id' => $id
        ]);
    }
}
