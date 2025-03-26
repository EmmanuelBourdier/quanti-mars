<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commentaire', name: 'app_commentaire')]
    public function index( Request $request): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = $form->getData();
            $commentaire->setCreateAt(new \DateTimeImmutable());
            $commentaire->setVerified('non');

            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_home');
        } else {

            return $this->render('commentaire/index.html.twig', [
                'controller_name' => 'CommentaireController',
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/liste-commentaires', name: 'app_commentaire_liste')]
public function commentList( EntityManagerInterface $entityManager): Response
{
    $commentaires = $entityManager->getRepository(Commentaire::class)->findByVerified();

    return $this->render('commentaire/commentaires_liste.html.twig', [
        'commentaires' => $commentaires,
    ]);
}

}
