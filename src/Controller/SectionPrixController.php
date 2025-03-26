<?php

namespace App\Controller;


use App\Repository\AbonnementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PackRepository;

class SectionPrixController extends AbstractController
{

    public function index(PackRepository $packRepository, AbonnementRepository $abonnementRepository): Response
    {
        return $this->render('components/section-prix.html.twig', [
            'packs' => $packRepository->findAll(),'abonnements'=> $abonnementRepository->findAll()
             ]
        );
    }
}
