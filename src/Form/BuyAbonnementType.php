<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class BuyAbonnementType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
        ->add('abonnement', ChoiceType::class, [
            'label' => 'Choisir un Abonnement',
            'choices' => [
                'Abonnement 1' => 1,
                'Abonnement 2' => 2,
                'Abonnement 3' => 3,
            ],
            'expanded' => true, // renders as radio buttons
            'multiple' => false, // only one can be selected
            'attr' => ['class' => 'custom-radio'], 
        ])
        ->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();

                if (empty($data['abonnement'])) {
                    $form->addError(new FormError('Vous devez en choisir un'));
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}