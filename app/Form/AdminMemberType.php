<?php

namespace App\Form;

use App\Entity\Cities;
use App\Entity\Consummables;
use App\Entity\Genders;
use App\Entity\PostalCode;
use App\Entity\Users;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\StringType;
use Faker\Provider\ar_EG\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Form\DataTransformer\PostalCodeToNumberTransformer;
use App\Form\DataTransformer\CityToNameTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminMemberType extends AbstractType
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
             ->add('username', TextType::class,[
                 'label' => 'Username',
             ])
             ->add('gender', EntityType::class, [
                'class' => Genders::class,
                'choice_label' => 'type',
                'attr' => ['class' => 'form-control'],
                'label' => 'Genre',
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom',
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Prénom',
            ])
            ->add('phone', TextType::class,[
                'label' => 'Téléphone',
            ])
            ->add('email', EmailType::class,[
                'label' => 'Email'
            ])
            
            ->add('birthday', null, [
                'label' => 'Date de naissance',
                'widget' => 'single_text'
            ])
            ->add('street', TextType::class,[
                'label' => 'Adresse',
            ])
            ->add('adress_complement', TextType::class,[
                'label' => 'Complément d\'adresse',
                'required' => false,
            ])
            ->add('postalcode', TextType::class, [
                'label' => 'Code Postal',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('is_organization', CheckboxType::class, [
                'label' => 'Structure ?',
                'attr' => ['class' => 'form-control form-check-input'],
                'required' => false,
            ])

            ->add('num_siret')
            ->add('name_organization')
            
            ->add('first_membership', null, [
                'label' => 'Date de la première adhésion',
                'widget' => 'single_text'
            ])
            ->add('last_membership', null, [
                'label' => 'Date de la derniere adhésion',
                'widget' => 'single_text',
                'required' => false,
            ]);

            if ($options['is_edit_mode']) {
                $builder->add('is_validated', CheckboxType::class, [
                    'label' => 'Valider l\'adhésion',
                    'required' => false,
                    'attr' => ['class' => 'form-control'], 
                ]);
            };
         
        $builder->get('city')->addModelTransformer($this->cityToNameTransformer);
        $builder->get('postalcode')->addModelTransformer($this->postalCodeTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'is_edit_mode' => false,
        ]);
    }
}
