<?php

namespace App\Form;

use App\Entity\events;
use App\Entity\Participants;
use App\Entity\persons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('is_validated')
            ->add('event', EntityType::class, [
                'class' => events::class,
                'choice_label' => 'id',
            ])
            ->add('person', EntityType::class, [
                'class' => persons::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
