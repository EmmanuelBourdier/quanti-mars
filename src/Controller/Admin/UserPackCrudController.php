<?php

namespace App\Controller\Admin;

use App\Entity\UserPack;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class UserPackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserPack::class;
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
            AssociationField::new('pack')->setLabel('Pack')->formatValue(function ($value, $entity) {
                return $entity->getPack()->getName(); 
            }),
            IntegerField::new("credit")->setLabel("Credit")->hideOnForm(),
        ];
    }
   
}
