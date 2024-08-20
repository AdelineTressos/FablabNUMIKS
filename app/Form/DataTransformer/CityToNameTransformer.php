<?php

namespace App\Form\DataTransformer;

use App\Entity\Cities;
use App\Repository\CitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CityToNameTransformer implements DataTransformerInterface
{
    private $citiesRepository;
    private $entityManager;

    public function __construct(CitiesRepository $citiesRepository, EntityManagerInterface $entityManager)
    {
        $this->citiesRepository = $citiesRepository;
        $this->entityManager = $entityManager;
    }

    public function transform($value): mixed
    {
        if (null === $value) {
            return '';
        }

        return $value->getNameCity();
    }

    public function reverseTransform($value): mixed
    {
        if (!$value) {
            return null;
        }

        $city = $this->citiesRepository->findOneBy(['name_city' => $value]);

        
        if (null === $city) {
            $city = new Cities();
            $city->setNameCity($value);
            
            $this->entityManager->persist($city);
            $this->entityManager->flush();
        }

        return $city;
    }
}
