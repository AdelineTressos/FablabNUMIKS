<?php

namespace App\Form;

use App\Entity\Cities;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitiesType extends AbstractType
{
    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_city')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cities::class,
        ]);
    }

    
    // Getter pour la propriété name
    public function getName(): ?string
    {
        return $this->name;
    }

    // Setter pour la propriété name
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
