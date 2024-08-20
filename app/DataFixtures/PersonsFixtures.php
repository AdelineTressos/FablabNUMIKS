<?php

namespace App\DataFixtures;

use App\Entity\Persons;
use App\DataFixtures\GendersFixtures;
use App\DataFixtures\CitiesFixtures;
use App\DataFixtures\PostalCodeFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PersonsFixtures extends Fixture implements DependentFixtureInterface
{
    public const PERSON_REFERENCE = 'person-';
    public function load(ObjectManager $manager)
    {
        // Création de quelques personnes de test
        $personsData = [
            [
                'lastname' => 'Doe',
                'firstname' => 'John',
                'phone' => '123456789',
                'email' => 'john.doe@example.com',
                'is_visitor' => true,
            ],
            [
                'lastname' => 'Smith',
                'firstname' => 'Jane',
                'phone' => '987654321',
                'email' => 'jane.smith@example.com',
                'is_visitor' => true,
            ],
        ];

        foreach ($personsData as $personData) {
            $person = new Persons();
            $person->setLastname($personData['lastname'])
                ->setFirstname($personData['firstname'])
                ->setPhone($personData['phone'])
                ->setEmail($personData['email'])
                ->setIsVisitor($personData['is_visitor'])

            // Ajoutez d'autres attributs et relations si nécessaire
                ->setGender($this->getReference(GendersFixtures::GENDERS_REFERENCE))
                ->setPostalcode($this->getReference(PostalCodeFixtures::POSTALCODE_REFERENCE))
                ->setCity($this->getReference(CitiesFixtures::CITY_REFERENCE));
            

            $manager->persist($person);
        }

        $manager->flush();
        $this->addReference(self::PERSON_REFERENCE, $person);
    }
    public function getDependencies()
    {
        return array(
            GendersFixtures::class,
            CitiesFixtures::class,
            PostalCodeFixtures::class,
        );
    }
}
