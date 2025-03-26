<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Abonnement;
use App\Entity\UserPack;
use App\Entity\UserAbonnement;
use App\Form\BuyAbonnementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use DateTimeImmutable;

class AbonnementController extends AbstractController
{

    #[Route('/utiliser-abonnement', name: 'app_abonnement_use')]
    public function useAbonnement(EntityManagerInterface $entityManager): Response
    {
       
         $user = $this->getUser();
        //dd($user);

        if (!$user instanceof User) {
            throw new \LogicException('The user is not an instance of User. Actual type: ' . get_class($user));
        }

        $userId = $user->getId();
        //dd($userId);
        $userAbonnement = $entityManager->getRepository(UserAbonnement::class)->findOneById([
            'userId' => $userId
        ]);
        //dd($userAbonnement);

       
        $finishedAt= $userAbonnement->getFinishedAt();
        //dd($quantity);
        $currentDate= new DateTimeImmutable();
        if ($userAbonnement && $currentDate > $finishedAt) {
            $this->addFlash('error', 'L \'abonnement est terminé veuillez le renouveler pour continuer');
            
            
        } else {
            $this->addFlash('success', 'Abonnement utilisé avec succés!');
        }

        return $this->redirectToRoute('app_account');
    }


    /* nouvelle logique plus souple */


#[Route('/acheter-abonnement', name: 'app_abonnement_buy')]
public function buyAbonnement(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
{
        $user = $this->getUser();

        if (!$user instanceof User) {
            $session->set('_security.main.target_path', $this->generateUrl('app_abonnement_buy'));

           return new RedirectResponse($this->generateUrl('app_login'));
        }

        $userId = $user->getId();

        $userAbonnement = $entityManager->getRepository(UserAbonnement::class)->findOneById($userId);

    if ($userAbonnement) {
        {
            $this->addFlash('error', 'Vous avez déjà un Abonnement en cours d\'utilisation');
            return $this->redirectToRoute('app_account');
        }
    }

       $userPack = $entityManager->getRepository(UserPack::class)->findOneByCredit([
            'userId' => $userId
        ]);

         if ($userPack) {
        {
            $this->addFlash('error', 'Vous avez déjà un pack en cours d\'utilisation');
            return $this->redirectToRoute('app_account');
        }
    }

    $abonnements=$entityManager->getRepository(Abonnement::class)->findAll();


    $form = $this->createForm(BuyAbonnementType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $abonnement = $form->getData();
        $abonnementId = $abonnement['abonnement'];
       

        // Redirect to the summary page with the packId
        return $this->redirectToRoute('app_abonnement_summary', ['abonnementId' => $abonnementId]);
    }

    return $this->render('abonnement/buy_abonnement.html.twig', ['form' => $form->createView(), 'abonnements'=>$abonnements]);
}

#[Route('/acheter-abonnement/resume', name: 'app_abonnement_summary')]
public function abonnementSummary(Request $request, EntityManagerInterface $entityManager): Response
{
    $abonnementId = $request->query->get('abonnementId');
    // Fetch the pack details using the packId
    $abonnement = $entityManager->getRepository(Abonnement::class)->find($abonnementId);

    if (!$abonnement) {
        throw $this->createNotFoundException('abonnement n\'existe pas');
    }

    return $this->render('abonnement/abonnement_summary.html.twig', [
        'abonnement' => $abonnement,
    ]);
}

#[Route('/acheter-abonnement/confirmation', name: 'app_abonnement_confirm')]
public function abonnementConfirm(Request $request, EntityManagerInterface $entityManager): Response
{
    $abonnementId = $request->query->get('abonnementId');
    $abonnement = $entityManager->getRepository(Abonnement::class)->find($abonnementId);

    if (!$abonnement) {
        throw $this->createNotFoundException('Abonnement not found');
    }

    $user = $this->getUser();

    $userAbonnement = new UserAbonnement();
    $userAbonnement->setAbonnement($abonnement);
    $userAbonnement->setUser($user);
    $userAbonnement->setCreatedAt(
        new DateTimeImmutable()
    );
    $userAbonnement->setFinishedAt(
            (new DateTimeImmutable())->modify(sprintf('+%d days', $abonnement->getDuration()))
        );

    $entityManager->persist($userAbonnement);
    $entityManager->flush();

    $this->addFlash('success', 'Abonnement acheté avec succès!');

    return $this->redirectToRoute('app_account');


}

}