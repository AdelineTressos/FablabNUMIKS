<?php

namespace App\Form;

use App\Form\DataTransformer\PostalCodeToNumberTransformer;
use App\Form\DataTransformer\CityToNameTransformer;
use App\Entity\cities;
use App\Entity\genders;
use App\Entity\Persons;
use App\Entity\PostalCode;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class VisitorEventRegistrationType extends AbstractType
{
    private $postalCodeTransformer;
    private $cityToNameTransformer;

    public function __construct(PostalCodeToNumberTransformer $postalCodeTransformer,CityToNameTransformer $cityToNameTransformer)
    {
        $this->postalCodeTransformer = $postalCodeTransformer;
        $this->cityToNameTransformer = $cityToNameTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('lastname', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : Dupont'],
            'label' => 'Nom',
        ])
        ->add('firstname', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : Michel'],
            'label' => 'Prénom',
        ])
        ->add('phone', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : 0601020304'],
            'label' => 'Téléphone',
        ])
        ->add('email', EmailType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : exemple@hotmail.fr'],
            'label' => 'E-mail',
        ])
        // ->add('is_visitor')
        ->add('gender', EntityType::class, [
            'class' => genders::class,
            'label'=>'Genre',
            'choice_label' => 'id',
            'choice_label' => 'type',
            'expanded' => true, // Cette option rendra les boutons radio
        ])

        ->add('postalcode', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre code postal'],
            'label' => 'Code Postal',
            'required' => false,
        ])

        ->add('city', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : Montpellier'],
            'label' => 'Ville',
            'required' => false,
        ])


        // ->add('save', SubmitType::class, [
        //     'label' => 'Envoyer'
        // ])
    ;
    $builder->get('city')->addModelTransformer($this->cityToNameTransformer);
    $builder->get('postalcode')->addModelTransformer($this->postalCodeTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Persons::class,
        ]);
    }
}
