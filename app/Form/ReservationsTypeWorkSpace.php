<?php

namespace App\Form;

use App\Entity\events;
use App\Entity\machines;
use App\Entity\Reservations;
use App\Entity\users;
use App\Entity\workspaces;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsTypeWorkSpace extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_reservation', null, [
                'widget' => 'single_text',
            ])
            ->add('start_hour', null, [
                'widget' => 'single_text',
            ])
            ->add('end_hour', null, [
                'widget' => 'single_text',
            ])
            ->add('is_validated')
            ->add('workspace', EntityType::class, [
                'class' => workspaces::class,
                'choice_label' => 'name_workspace',
            ])

            ->add('user', EntityType::class, [
                'class' => users::class,
                'choice_label' => 'username',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
