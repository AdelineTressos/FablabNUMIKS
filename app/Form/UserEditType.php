<?php

namespace App\Form;

use App\Form\DataTransformer\PostalCodeToNumberTransformer;
use App\Form\DataTransformer\CityToNameTransformer;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserEditType extends AbstractType
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
            ->add('phone', 
                TelType::class,
                [
                'attr' => [
                    'class'=> 'form-control'
                ]
                ]
            )
            ->add('email',
                EmailType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Email(),
                        new Assert\Length(['min' => 2, 'max' => 150])
                    ],
                    'attr' => [
                        'class'=> 'form-control'
                    ]
                ]
            )
            ->add('street',
                TextType::class,
                [
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(['min' => 2, 'max' => 150])
                    ],
                    'attr' => [
                        'class'=> 'form-control'
                    ]
                ]
            )
            ->add('adress_complement',
                TextType::class,
                [
                    'constraints' => [
                        new Assert\Length(['min' => 2, 'max' => 150])
                    ],
                    'attr' => [
                        'class'=> 'form-control'
                    ],
                    'required' => false
                ]
            )
            ->add('postalcode',            
            TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Code Postal',
                'required' => false,
            ] 
            )
            ->add('city', 
            TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Ville',
                'required' => false,
            ]                      
            )
            ->add(
                'submit',
                SubmitType::class, 
                [
                    'attr' =>['class' =>'btn'],
                    'label' => 'Enregistrer'
                ]
                );
            $builder->get('city')->addModelTransformer($this->cityToNameTransformer);
            $builder->get('postalcode')->addModelTransformer($this->postalCodeTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
            'csrf_protection' => false,
        ]);
    }
}
