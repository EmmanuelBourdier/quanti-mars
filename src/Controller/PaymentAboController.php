<?php

namespace App\Controller;

use App\Entity\Abonnement;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentAboController extends AbstractController
{
    #[Route('/compte/paiementAbo/{abonnementId}', name: 'app_account_paymentAbo')]
    public function index($abonnementId, EntityManagerInterface $entityManager): Response
    {
        
        $abonnement = $entityManager->getRepository(Abonnement::class)->find($abonnementId);

        Stripe::setApiKey('sk_test_51QPSD4CkmfYHbFpEMd0aqMKo2aakRutcMVdFnSmCXy67yCTycqG2NpNFgm71B9K1LSly2IdFDZgjPaUV2o76wl9P008uOvzmEn');
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
         $successUrl = $this->generateUrl('app_abonnement_confirm', ['abonnementId' => $abonnementId], UrlGeneratorInterface::ABSOLUTE_URL);
        $cancelUrl = $YOUR_DOMAIN . '/cancel.html';
        $checkout_session = Session::create([
        'line_items' => [[
        # avec price_data, on peut définir l'article en direct
        'price_data' => [
            'currency' => 'eur',
            # le montant est en centimes (*100)
            'unit_amount' => ($abonnement->getPrice() * 100),
            'product_data' => [
                'name' => $abonnement->getName(),
                'metadata' => [
                            'duration' => $abonnement->getDuration(),
                        ],
            ],
        ],
        'quantity' => 1,
        ]],
    'mode' => 'payment',
    'success_url' => $successUrl,
    'cancel_url' => $cancelUrl,
]);
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
return $this->redirect( $checkout_session->url  );

    }
}