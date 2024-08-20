<?php

namespace App\Form;

use App\Form\DataTransformer\PostalCodeToNumberTransformer;
use App\Form\DataTransformer\CityToNameTransformer;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Genders;
use App\Entity\PostalCode;
use App\Entity\Cities;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Assert;


class RegistrationFormType extends AbstractType
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
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : Nom'],
                'label' => 'Nom',
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : Prénom'],
                'label' => 'Prénom',
            ])
            ->add('phone', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : 0601020304'],
                'label' => 'Téléphone',
            ])
            ->add('gender', EntityType::class, [
                'class' => Genders::class,
                'choice_label' => 'type',
                'attr' => ['class' => 'form-control'],
                'label' => 'Genre',
            ])
            ->add('postalcode', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre code postal'],
                'label' => 'Code Postal',
                'required' => false,
            ])
            

            ->add('city', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : Marseille'],
                'label' => 'Ville',
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : Nom_Prenom3503'],
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : exemple@hotmail.fr'],
                'label' => 'E-mail',
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'label' => 'Date de naissance',
            ])
            ->add('street', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : Montpellier'],
                'required' => false, 'label' => 'Ville',

            ])
            ->add('adress_complement', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : 10 rue des étoiles'],
                'required' => false,
                'label' => 'Adresse',
            ])
            ->add('is_organization', CheckboxType::class, [
                'attr' => ['class' => 'form-check-input'],
                'required' => false,
                'label' => 'Avez vous une organisation ? ',
            ])
            ->add('num_siret', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : 2312 1231 34283428 '],
                'required' => false,
                'label' => 'Numero de siret',
            ])
            ->add('name_organization', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Exemple : nom de l\'organisation'],
                'required' => false,
                'label' => 'Nom de l\'organisation',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-check-input'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
                'label' => 'Validez les conditions géneral '
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control', 'autocomplete' => 'new-password', 'placeholder' => 'Exemple : Exemple@6232'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veulliez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ]);
            $builder->get('city')->addModelTransformer($this->cityToNameTransformer);
            $builder->get('postalcode')->addModelTransformer($this->postalCodeTransformer);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
