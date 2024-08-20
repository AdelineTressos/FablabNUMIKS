<?php

namespace App\Form;

use App\Entity\CatConsummables;
use App\Entity\Consummables;
use App\Entity\UnitsConsummable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsummablesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_consummable', TextType::class, [
                'label' => 'Nom du consommable',
                'attr' => ['class' => 'form-control mb-3', 'placeholder' => 'Entrez le nom']
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Quantité',
                'attr' => ['class' => 'form-control mb-3', 'placeholder' => 'Entrez la quantité'],
                'html5' => true
            ])
            ->add('threshold', NumberType::class, [
                'label' => 'Seuil minimal',
                'attr' => ['class' => 'form-control mb-3', 'placeholder' => 'Définissez le seuil minimal'],
                'html5' => true
            ])
            ->add('cat_consummables', EntityType::class, [
                'class' => CatConsummables::class,
                'choice_label' => 'name_category',
                'label' => 'Catégorie de consommable',
                'attr' => ['class' => 'form-select mb-3']
            ])
            ->add('unit_consummables', EntityType::class, [
                'class' => UnitsConsummable::class,
                'choice_label' => 'name_unit',
                'label' => 'Unité de mesure',
                'attr' => ['class' => 'form-select mb-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consummables::class,
        ]);
    }
}
