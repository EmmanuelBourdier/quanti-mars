<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Pack;
use App\Entity\UserAbonnement;
use App\Entity\UserPack;
use App\Form\BuyPackType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PackController extends AbstractController
{

    #[Route('/utiliser-pack', name: 'app_pack_use')]
    public function usePack(EntityManagerInterface $entityManager): Response
    {
       
         $user = $this->getUser();
        //dd($user);

        if (!$user instanceof User) {
            throw new \LogicException('The user is not an instance of User. Actual type: ' . get_class($user));
        }

        $userId = $user->getId();
        //dd($userId);
        $userPack = $entityManager->getRepository(UserPack::class)->findOneByCredit([
            'userId' => $userId
        ]);
        //dd($userPack);
        if (!$userPack) {
        $this->addFlash('error', 'Vous n\'avez de pack avec des crédits ');
        return $this->redirectToRoute('app_account');
    }
        $credit= $userPack->getCredit();
        //dd($credit);

        $quantity= $userPack->getPack()->getQuantity();
        //dd($quantity);

        if ($userPack && $credit >= 1 && $credit <= $quantity) {
            $userPack->setCredit($userPack->getCredit() -1);
            $entityManager->persist($userPack);
            $entityManager->flush();

            $this->addFlash('success', 'Pack utilisé avec succés!');
        } else {
            $this->addFlash('error', 'plus de crédit disponible, achetez un pack pour continuer');
        }

        return $this->redirectToRoute('app_account');
    }


    /* nouvelle logique plus souple */


#[Route('/acheter-pack', name: 'app_pack_buy')]
public function buyPack(Request $request, EntityManagerInterface $entityManager,SessionInterface $session): Response
{
        $user = $this->getUser();

        if (!$user instanceof User) {
            $session->set('_security.main.target_path', $this->generateUrl('app_pack_buy'));

           return new RedirectResponse($this->generateUrl('app_login'));
        }

        $userId = $user->getId();

        $userPack = $entityManager->getRepository(UserPack::class)->findOneByCredit($userId);

    if ($userPack) {
        {
            $this->addFlash('error', 'Vous avez déjà un pack en cours d\'utilisation');
            return $this->redirectToRoute('app_account');
        }
    }

    $userAbonnement = $entityManager->getRepository(UserAbonnement::class)->findOneById($userId);

    if ($userAbonnement) {
        {
            $this->addFlash('error', 'Vous avez déjà un Abonnement en cours d\'utilisation');
            return $this->redirectToRoute('app_account');
        }
    }

    $packs=$entityManager->getRepository(Pack::class)->findAll();

    $form = $this->createForm(BuyPackType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $pack = $form->getData();
        $packId = $pack['pack'];
       

        // Redirect to the summary page with the packId
        return $this->redirectToRoute('app_pack_summary', ['packId' => $packId]);
    }

    return $this->render('pack/buy_pack.html.twig', ['form' => $form->createView(),'packs'=>$packs]);
}

#[Route('/acheter-pack/resume', name: 'app_pack_summary')]
public function packSummary(Request $request, EntityManagerInterface $entityManager): Response
{
    $packId = $request->query->get('packId');
    // Fetch the pack details using the packId
    $pack = $entityManager->getRepository(Pack::class)->find($packId);

    if (!$pack) {
        throw $this->createNotFoundException('Pack not found');
    }

    return $this->render('pack/pack_summary.html.twig', [
        'pack' => $pack,
    ]);
}

#[Route('/acheter-pack/confirmation', name: 'app_pack_confirm')]
public function packConfirm(Request $request, EntityManagerInterface $entityManager): Response
{
    $packId = $request->query->get('packId');
    $pack = $entityManager->getRepository(Pack::class)->find($packId);

    if (!$pack) {
        throw $this->createNotFoundException('Pack not found');
    }

    $user = $this->getUser();

   
   

    $userPack = new UserPack();
    $userPack->setPack($pack);
    $userPack->setUser($user);
    $userPack->setCredit($pack->getQuantity());

    $entityManager->persist($userPack);
    $entityManager->flush();

    $this->addFlash('success', 'Pack acheté avec succès!');

    return $this->redirectToRoute('app_account');


}

}
