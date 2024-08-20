<?php

namespace App\DataFixtures;

use App\Entity\Consummables;
use App\DataFixtures\UnitsConsummableFixtures ;
use App\DataFixtures\CatConsummablesFixtures ;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ConsummablesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Exemple de création de consommables
        $consumable1 = new Consummables();
        $consumable1->setNameConsummable('Papier A4');
        $consumable1->setQuantity(100);
        $consumable1->setThreshold(10);
        // $consumable1->setCatConsummables(); // Ajoutez la catégorie si nécessaire
        // $consumable1->setUnitConsummables(); // Ajoutez l'unité si nécessaire
        
        $manager->persist($consumable1);

        $consumable2 = new Consummables();
        $consumable2->setNameConsummable('Cartouche d\'encre');
        $consumable2->setQuantity(20);
        $consumable2->setThreshold(5)
        
        ->setUnitConsummables($this->getReference(UnitsConsummableFixtures::UNITS_REFERENCE))
        ->setCatConsummables($this->getReference(CatConsummablesFixtures::CATEGORIES_REFERENCE));

        $manager->persist($consumable2);

        // Répétez pour d'autres consommables
        $manager->flush();
    }
    public function getDependencies()
    {
        return array(
            UnitsConsummableFixtures::class,
            CatConsummablesFixtures::class,
        );
    }
}
