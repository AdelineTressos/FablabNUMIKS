<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Reservations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ReservationsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        for ($i = 0; $i < 6; $i++) {
            $reservation = new Reservations();
            $reservation->setDateReservation($faker->dateTimeBetween('-1 months', '+1 months'));
            $reservation->setStartHour($faker->dateTime($reservation->getDateReservation()));
            $reservation->setEndHour((clone $reservation->getStartHour())->modify('+2 hours'));
            $reservation->setIsValidated($faker->boolean(70)); // 70% de chance d'être validée
            $reservation->setStateReservation($faker->randomElement(['confirmed', 'pending', 'cancelled']));
    
        $reservation->setUser($this->getReference(UsersFixtures::USERS_REFERENCE))
                    ->setWorkspace($this->getReference(WorkspacesFixtures::WORKSPACES_REFERENCE))
                    ->setMachine($this->getReference(MachinesFixtures::MACHINE_REFERENCE))
                    ->setEvent($this->getReference(EventsFixtures::EVENTS_REFERENCE));
        
        $manager->persist($reservation);
        }
        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsersFixtures::class,
            WorkspacesFixtures::class,
            MachinesFixtures::class,
            EventsFixtures::class,
            // Liste des classes de fixtures dont ReservationsFixtures dépend
        ];
    }
}
