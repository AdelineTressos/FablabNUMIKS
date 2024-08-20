<?php

namespace App\Form;

use App\Entity\cities;
use App\Entity\genders;
use App\Entity\Persons;
use App\Entity\PostalCode;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('phone')
            ->add('email')
            ->add('is_visitor')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Persons::class,
        ]);
    }
}
