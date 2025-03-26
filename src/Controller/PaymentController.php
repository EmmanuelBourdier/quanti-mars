<?php

namespace App\Controller;

use App\Entity\Pack;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    #[Route('/compte/paiement/{packId}', name: 'app_account_payment')]
    public function index($packId, EntityManagerInterface $entityManager): Response
    {
        
        $pack = $entityManager->getRepository(Pack::class)->find($packId);

        Stripe::setApiKey('sk_test_51QPSD4CkmfYHbFpEMd0aqMKo2aakRutcMVdFnSmCXy67yCTycqG2NpNFgm71B9K1LSly2IdFDZgjPaUV2o76wl9P008uOvzmEn');
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
         $successUrl = $this->generateUrl('app_pack_confirm', ['packId' => $packId], UrlGeneratorInterface::ABSOLUTE_URL);
        $cancelUrl = $YOUR_DOMAIN . '/cancel.html';
        $checkout_session = Session::create([
        'line_items' => [[
        # avec price_data, on peut définir l'article en direct
        'price_data' => [
            'currency' => 'eur',
            # le montant est en centimes (*100)
            'unit_amount' => ($pack->getPrice() * 100),
            'product_data' => [
                'name' => $pack->getName(),
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


