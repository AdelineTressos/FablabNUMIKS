<?php

namespace App\DataFixtures;

use App\Entity\Genders;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GendersFixtures extends Fixture
{
    public const GENDERS_REFERENCE = 'gender';
    public function load(ObjectManager $manager)
    {
        // Création de quelques genres
        $genders = ['Madame', 'Monsieur', 'Autre'];
        
        foreach ($genders as $genderType) {
            $gender = new Genders();
            $gender->setType($genderType);


            $manager->persist($gender);
        }
        $this->addReference(self::GENDERS_REFERENCE, $gender);
        $manager->flush();
    }
}
