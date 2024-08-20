<?php

namespace App\Form;

use App\Entity\Machines;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class MachinesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_machine', TextType::class, [
                'label' => 'Nom de la machine',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom pour la machine.',
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le nom de la machine ne peut pas dépasser {{ limit }} caractères.',
                    ])
                ],
            ])
            ->add('number_machine', TextType::class, [
                'label' => 'Numéro de la machine',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le numéro de la machine ne peut pas dépasser {{ limit }} caractères.',
                    ])
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                    ])
                ],
            ])
            ->add('machine_picture', FileType::class, [
                'label' => 'Image de la machine',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier image valide (JPEG, PNG, GIF).',
                    ])
                ],
            ])
            ->add('member_access', CheckboxType::class, [
                'label' => 'Accès membre',
                'required' => false,
            ])
            ->add('is_booked', CheckboxType::class, [
                'label' => 'Réservé',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Machines::class,
        ]);
    }
}
