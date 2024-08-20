<?php

namespace App\Form;

use App\Entity\cities;
use App\Entity\Consummables;
use App\Entity\genders;
use App\Entity\PostalCode;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('phone')
            ->add('email')
            ->add('is_visitor')
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Role Admin' => 'ROLE_ADMIN',
                    'Role Super Admin' => 'ROLE_SUPERADMIN',
                    'Role User' => 'ROLE_USER', 
                ],
                'expanded' => true, 
                'multiple' => true,
            ])
            ->add('password')
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('street')
            ->add('adress_complement')
            ->add('is_organization')
            ->add('is_email_verified')
            ->add('is_validated')
            ->add('first_membership', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('last_membership', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('num_siret')
            ->add('name_organization')
            ->add('gender', EntityType::class, [
                'class' => genders::class,
                'choice_label' => 'id',
            ])
            ->add('postalcode', EntityType::class, [
                'class' => PostalCode::class,
                'choice_label' => 'id',
            ])
            ->add('city', EntityType::class, [
                'class' => cities::class,
                'choice_label' => 'id',
            ])
            ->add('consummable', EntityType::class, [
                'class' => Consummables::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
