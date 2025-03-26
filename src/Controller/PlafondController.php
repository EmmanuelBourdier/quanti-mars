<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlafondController extends AbstractController
{
    #[Route('/plafond', name: 'app_plafond')]
    public function index(): Response
    {
        return $this->render('plafond/index.html.twig', [
            'controller_name' => 'PlafondController',
        ]);
    }
}
