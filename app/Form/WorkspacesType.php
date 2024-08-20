<?php

namespace App\Form;

use App\Entity\Workspaces;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class WorkspacesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_workspace', TextType::class, [
                'label' => 'Nom de l\'espace',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'La description ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La description ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('member_access', CheckboxType::class, [
                'label' => 'Accès membre',
                'attr' => ['class' => 'form-check-input'],
                'required' => false,
            ])
            ->add('is_booked', CheckboxType::class, [
                'label' => 'Réservé',
                'attr' => ['class' => 'form-check-input'],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workspaces::class,
        ]);
    }
}
