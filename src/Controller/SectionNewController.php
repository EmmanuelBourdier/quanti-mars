<?php

namespace App\Controller;

use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SectionNewController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    

    #[Route('/derniere-actualite', name: 'app_new_current')]
public function currentNew( EntityManagerInterface $entityManager): Response
{
    $new = $entityManager->getRepository(News::class)->findByCurrent();

    return $this->render('news/news_current.html.twig', [
        'new' => $new,
    ]);
}

}
