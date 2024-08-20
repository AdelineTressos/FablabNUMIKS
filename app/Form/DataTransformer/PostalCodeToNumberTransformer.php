<?php

namespace App\Form\DataTransformer;

use App\Entity\PostalCode;
use App\Repository\PostalCodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class PostalCodeToNumberTransformer implements DataTransformerInterface
{
    private $postalCodeRepository;
    private $entityManager;

    public function __construct(PostalCodeRepository $postalCodeRepository, EntityManagerInterface $entityManager)
    {
        $this->postalCodeRepository = $postalCodeRepository;
        $this->entityManager = $entityManager;
    }

    public function transform(mixed $value): mixed
    {
        if (null === $value) {
            return '';
        }

        return (string)$value->getNumber();
    }

    public function reverseTransform(mixed $value): mixed
    {
        if (!$value) {
            return null;
        }

        $postalCode = $this->postalCodeRepository->findOneBy(['number' => $value]);

        if (null === $postalCode) {
            
            $postalCode = new PostalCode();
            $postalCode->setNumber($value);
            
            $this->entityManager->persist($postalCode);
            $this->entityManager->flush();
        }

        return $postalCode;
    }
}
