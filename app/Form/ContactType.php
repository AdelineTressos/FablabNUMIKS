<?php

namespace App\Form;

use App\Entity\Contact;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                    'lastname', 
                    TextType::class,
                    [
                        'label' => "Nom",
                        'attr' => ['minlenght' => '1', 'maxlenght' => '50']
                    ]
                )
            ->add(
                    'firstname', 
                    TextType::class,
                    [
                        'label' => "Prénom",
                        'required' => false,
                        'attr' => ['minlenght' => '1', 'maxlenght' => '50']
                    ]
                    )
            ->add(
                    'email',
                    EmailType::class,
                    [
                        'label' => "Adresse mail",
                        'constraints' => [
                            new Assert\NotBlank(),
                            new Assert\Email(),
                            new Assert\Length(['min' => 2, 'max' => 150])
                        ]
                    ]
                )
            ->add(
                    'phone', 
                    TelType::class,
                    [
                        'label' => "Téléphone",
                        'required' => false,
                    ]
                    )
            ->add(
                    'message', 
                    TextareaType::class, 
                    [
                        'attr' => ['rows' => 7],
                        'label' => 'Message'
                    ]
                )
            ->add(
                'submit',
                SubmitType::class, 
                [
                    'label' => 'Envoyer'
                ]
            )
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'contact',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
