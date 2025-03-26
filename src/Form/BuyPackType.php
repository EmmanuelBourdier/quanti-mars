<?php
// src/Form/BuyPackType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class BuyPackType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
        ->add('pack', ChoiceType::class, [
            'label' => 'Choisir un Pack',
            'choices' => [
                'Pack 1' => 1,
                'Pack 2' => 2,
                'Pack 3' => 3,
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

                if (empty($data['pack'])) {
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