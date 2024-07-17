<?php

namespace App\Form;

// use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'password',
                PasswordType::class,
                [
                    'toggle' => true,
                    'label' => 'Mot de passe actuel',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'constraints' => [
                        new Assert\NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Assert\Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                            'max' => 4096,
                        ]),
                    ]
                ]
            )
            ->add(
                'newPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options' => [ 
                        'toggle' => true,                     
                        'mapped' => false,
                        'attr' => ['class' => 'form-control', 'autocomplete' => 'new-password', 'placeholder' => 'Exemple : Exemple@1234'],
                        'label' => "Nouveau mot de passe",
                        'constraints' => [
                            new Assert\NotBlank([
                                'message' => 'Veuillez entrer un mot de passe',
                            ]),
                            new Assert\Length([
                                'min' => 6,
                                'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                                'max' => 4096,
                            ]),
                        ]
                    ],
                    'second_options' => [
                        'toggle' => true,
                        'mapped' => false,
                        'attr' => [ 'class' => 'form-control'],
                        'label' => "Confirmer le nouveau mot de passe",
                        'label_attr' => ['class' => 'mt-2'],
                        'constraints' => [
                            new Assert\NotBlank([
                                'message' => 'Veuillez entrer un mot de passe',
                            ]),
                            new Assert\Length([
                                'min' => 6,
                                'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                                'max' => 4096,
                            ]),
                        ]                         
                    ],
                    'invalid_message' => 'Les mots de passe ne correspondent pas.'

                ]
            )
            ->add(
                'submit',
                SubmitType::class, 
                [
                    'label' => 'Enregistrer',
                    'attr' => ['class' => 'btn btn-custom']
                ]
            )
        ;
    }

}