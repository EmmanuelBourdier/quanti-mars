<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CommentaireRepository;

class SectionCommentaireController extends AbstractController
{

    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('components/section-commentaire.html.twig', [
            'controller_name' => 'SectionCommentaireController',
            'commentaires' => $commentaireRepository->findRandomVerifiedComments()
             ]
        );
    }
}
