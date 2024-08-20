<?php

namespace App\Form;

use App\Entity\Publications;
use App\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PublicationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date_publication', DateType::class, [
            'widget' => 'single_text',
            'input'  => 'datetime',
            'format' => 'yyyy-MM-dd',
            'attr' => ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD'],
            'data' => new \DateTime(), 
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer une date de publication.',
                ]),
            ],
            'required' => true,
        ])

            ->add('title')
            ->add('description')
            ->add('front_picture_file', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Choisir une image dans un fichier',
            ])

            ->add('media')
            ->add('is_published')
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'firstname', 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :admin OR u.roles LIKE :superadmin')
                        ->setParameter('admin', '%ROLE_ADMIN%') 
                        ->setParameter('superadmin', '%ROLE_SUPERADMIN%');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publications::class,
        ]);
    }
}
