<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CommentaireRepository;
use App\Repository\NewsRepository;

class SlideController extends AbstractController
{
    #[Route('/slide', name: 'app_slide')]
    public function index(CommentaireRepository $commentaireRepository, NewsRepository $newsRepository): Response
    {
        return $this->render('components/section-slide.html.twig', [
         'comments' => $commentaireRepository->findRandomVerifiedComments(),
          'news' => $newsRepository->findByCurrent()
                
        ]);
    }
}
