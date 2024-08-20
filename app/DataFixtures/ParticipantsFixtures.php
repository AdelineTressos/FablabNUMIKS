<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Participants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Faker\Factory;

class ParticipantsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
      
        for ($i = 0; $i < 3; $i++) {
            $participant = new Participants();
            $participant->setIsValidated($faker->boolean(70))

                        ->setPerson($this->getReference(PersonsFixtures::PERSON_REFERENCE))
                        ->setEvent($this->getReference(EventsFixtures::EVENTS_REFERENCE));
            


            $manager->persist($participant);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventsFixtures::class, // Replace with the actual class name for events fixtures
            PersonsFixtures::class, // Replace with the actual class name for persons fixtures
        ];
    }
}
