<?php

namespace App\Controller\Admin;

use App\Entity\Abonnement;
use App\Entity\User;
use App\Entity\Commentaire;
use App\Entity\Contact;
use App\Entity\News;
use App\Entity\UserAbonnement;
use App\Entity\UserPack;
use App\Entity\Pack;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<a href="' . $this->generateUrl('app_home') . '">Quanti Plaque</a>');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Packs', 'fas fa-list', Pack::class);
        yield MenuItem::linkToCrud('Abonnements', 'fas fa-list', Abonnement::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-list', Commentaire::class);
        yield MenuItem::linkToCrud('Contact', 'fas fa-list', Contact::class);
        yield MenuItem::linkToCrud('Actualités', 'fas fa-list', News::class);
        yield MenuItem::linkToCrud('Souscription Abonnements', 'fas fa-list', UserAbonnement::class);
        yield MenuItem::linkToCrud('Achat Packs', 'fas fa-list', UserPack::class);
        
    }
}
