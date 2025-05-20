<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('actualPassword', PasswordType::class, [
            'label' => 'Mot de passe actuel',
            'attr' => ['placeholder' => 'Veuillez entrer votre mot de passe actuel'],
            'mapped' => false
        ])
           ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Saisissez votre nouveau mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options'  => [
                    'label' => 'Nouveau mot de passe',
                    'attr' => ['placeholder' => 'Saisissez votre nouveau mot de passe'],
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmer le nouveau mot de passe',
                    'attr' => ['placeholder' => 'Veuillez confirmer votre nouveau mot de passe'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'mapped' => false,
            ])
             ->add('submit', SubmitType::class, [
                'label' => 'Modifier mot de passe', 'attr' => ['class' => 'btn btn-success']
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions() ['passwordHasher'];
                $isValid = $passwordHasher->isPasswordValid($user, $form->get('actualPassword')->getData());
                
                if (!$isValid) {
                    $form->get('actualPassword')->addError(new FormError('Mot de passe incorrect'));
                }
            })
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null
        ]);
    }
}
