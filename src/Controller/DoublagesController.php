<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DoublagesController extends AbstractController
{
    #[Route('/doublages', name: 'app_doublages')]
    public function index(): Response
    {
        return $this->render('doublages/index.html.twig', [
            'controller_name' => 'DoublagesController',
        ]);
    }
}
