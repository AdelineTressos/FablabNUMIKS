<?php

namespace App\Form;

use App\Entity\Events;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_event')
            ->add('start_date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('end_date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('start_hour', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('end_hour', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('front_media')
            ->add('is_published')
            ->add('is_member_only')
            ->add('max_participants')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
