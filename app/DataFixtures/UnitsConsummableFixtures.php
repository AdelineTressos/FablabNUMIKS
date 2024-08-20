<?php

namespace App\DataFixtures;

use App\Entity\UnitsConsummable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UnitsConsummableFixtures extends Fixture
{
    public const UNITS_REFERENCE = 'unit';
    public function load(ObjectManager $manager)
    {
        // Création de quelques unités de consommables
        $units = ['Piece', 'Kilogram', 'Liter'];

        foreach ($units as $unitName) {
            $unit = new UnitsConsummable();
            $unit->setNameUnit($unitName);

            $manager->persist($unit);
        }
        $this->addReference(self::UNITS_REFERENCE, $unit);
        $manager->flush();
    }
}
