<?php

namespace App\Form;

use App\Entity\UnitsConsummable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UnitsConsummableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name_unit', TextType::class, [
            'label' => 'Nom de l\'unité',
            'attr' => [
                'class' => 'form-control mb-3',
                'placeholder' => 'Entrez le nom de l\'unité consommable',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UnitsConsummable::class,
        ]);
    }
}
