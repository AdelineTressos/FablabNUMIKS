<?php

namespace App\Form;

use App\Entity\Events;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AdminEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_event', TextType::class, [
                'label' => 'Nom de l\'évènement'
            ])
            ->add('start_date', null, [
                'widget' => 'single_text',
                'label' => 'Date de début',
            ])
            ->add('end_date', null, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'required' => false, 
            ])
            ->add('start_hour', null, [
                'widget' => 'single_text',
                'input' => 'string',
                'label' => "Horaire de début"
            ])
            ->add('end_hour', null, [
                'widget' => 'single_text',
                'input' => 'string',
                'label' => 'Horaire de fin'
            ])
            ->add('description', null, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control description-field']
            ])
            ->add('front_media', null,[
                'label' => 'Image de présentation',
                'attr' => ['placeholder' => 'URL, https://...'],
            ])
            ->add('is_published', null, [
                'label' => 'Publier l\'évènement',
                'attr' => ['class' => 'form-control']
            ])
            ->add('is_member_only', null,[
                'label' => 'Evènement réservé aux membres',
                'attr' => ['class' => 'form-control']
            ])
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
