<?php

namespace App\DataFixtures;

use App\Entity\CatConsummables;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CatConsummablesFixtures extends Fixture
{
    public const CATEGORIES_REFERENCE = 'category';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Créer des catégories de consommables fictives
        $categories = ['Catégorie A', 'Catégorie B', 'Catégorie C'];

        foreach ($categories as $categoryName) {
            $category = new CatConsummables();
            $category->setNameCategory($categoryName);

            $manager->persist($category);
        }
        $this->addReference(self::CATEGORIES_REFERENCE, $category);
        $manager->flush();
    }
}
