<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LexicController extends AbstractController
{
    #[Route('/lexic', name: 'app_lexic')]
    public function index(): Response
    {
        return $this->render('lexic/index.html.twig', [
            'controller_name' => 'LexicController',
        ]);
    }
}
