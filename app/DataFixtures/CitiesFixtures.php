<?php

namespace App\DataFixtures;

use App\Entity\Cities;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CitiesFixtures extends Fixture
{
    public const CITY_REFERENCE = 'city';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Créer des villes fictives
        $cities = ['Paris', 'London', 'New York', 'Tokyo'];

        foreach ($cities as $cityName) {
            $city = new Cities();
            $city->setNameCity($cityName);

            $manager->persist($city);
        }
        $this->addReference(self::CITY_REFERENCE, $city);
        $manager->flush();
    }
}
