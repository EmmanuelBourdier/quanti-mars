<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InfotechController extends AbstractController
{
    #[Route('/infotech', name: 'app_infotech')]
    public function index(): Response
    {
        return $this->render('infotech/index.html.twig', [
            'controller_name' => 'InfotechController',
        ]);
    }
}
