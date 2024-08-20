<?php

namespace App\DataFixtures;

use App\Entity\PostalCode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostalCodeFixtures extends Fixture
{
    public const POSTALCODE_REFERENCE = 'postalCode';
    public function load(ObjectManager $manager)
    {
        // Création de quelques codes postaux
        $postalCodes = [75001, 75002, 75003, 75004, 75005];

        foreach ($postalCodes as $code) {
            $postalCode = new PostalCode();
            $postalCode->setNumber($code);

            $manager->persist($postalCode);
        }
        $this->addReference(self::POSTALCODE_REFERENCE, $postalCode);
        $manager->flush();
    }
}
