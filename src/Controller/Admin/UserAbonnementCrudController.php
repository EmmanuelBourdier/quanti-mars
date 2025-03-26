<?php

namespace App\Controller\Admin;

use App\Entity\UserAbonnement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class UserAbonnementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserAbonnement::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Action::INDEX, Action::NEW);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user')->setLabel('Utilisateur'),
            AssociationField::new('abonnement')->setLabel('Abonnement')->formatValue(function ($value, $entity) {
                return $entity->getAbonnement()->getName(); // Assuming 'getName()' method exists in Abonnement entity
            }),
            DateTimeField::new('createdAt')->setLabel('Crée le'),
            DateTimeField::new('finishedAt')->setLabel('Se termine'),
        ];
    }
  
}
