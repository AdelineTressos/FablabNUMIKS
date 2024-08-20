<?php

namespace App\DataFixtures;

use App\Entity\Events;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventsFixtures extends Fixture
{
    public const EVENTS_REFERENCE = 'event';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Créer des événements fictifs
        for ($i = 0; $i < 10; $i++) {
            $event = new Events();
            $event->setNameEvent($faker->sentence(3));
            $event->setStartDate($faker->dateTimeBetween('-1 month', '+1 month'));
            $event->setEndDate($faker->dateTimeBetween($event->getStartDate(), '+1 month'));
            $event->setStartHour($faker->time('H:i'));
            $event->setEndHour($faker->time('H:i'));
            $event->setDescription($faker->paragraph(3));
            $event->setFrontMedia($faker->imageUrl());
            $event->setIsPublished($faker->boolean(80));
            $event->setIsMemberOnly($faker->boolean(20));
            $event->setMaxParticipants($faker->numberBetween(10, 100));

            
            $manager->persist($event);
        }
        $this->addReference(self::EVENTS_REFERENCE, $event);
        $manager->flush();
    }
}
