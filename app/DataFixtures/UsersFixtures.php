<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Users;
use App\DataFixtures\PersonsFixtures;
use App\DataFixtures\GendersFixtures;
use App\DataFixtures\CitiesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class UsersFixtures extends Fixture implements DependentFixtureInterface
{
    public const USERS_REFERENCE = 'user';
    private UserPasswordHasherInterface $passwordHasher;
    private $faker;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new Users();
            $isOrganization = $this->faker->boolean; // Stocker la valeur booléenne
            
            $user->setUsername($this->faker->userName)
                 ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
                 ->setRoles($i % 2 == 0 ? ['ROLE_USER'] : ['ROLE_ADMIN'])
                 ->setLastname($this->faker->lastName)
                 ->setFirstname($this->faker->firstName)
                 ->setPhone($this->faker->phoneNumber)
                 ->setEmail($this->faker->email)
                 ->setStreet($this->faker->streetAddress)
                 ->setAdressComplement($this->faker->secondaryAddress)
                 ->setIsOrganization($isOrganization)
                 ->setIsEmailVerified(true)
                 ->setIsValidated($this->faker->boolean(50))
                 ->setBirthday($this->faker->dateTimeThisCentury)
                 ->setFirstMembership($this->faker->dateTimeThisYear)
                 ->setLastMembership($this->faker->dateTimeThisYear)
                 ->setIsVisitor(false)
                 ->setGender($this->getReference(GendersFixtures::GENDERS_REFERENCE))
                 ->setPostalcode($this->getReference(PostalCodeFixtures::POSTALCODE_REFERENCE))
                 ->setCity($this->getReference(CitiesFixtures::CITY_REFERENCE));

            if ($isOrganization) { // Utiliser la variable
                $user->setNumSiret($this->faker->numerify('##########'))
                     ->setNameOrganization($this->faker->company);
            }
            

            $manager->persist($user);
        }
        $this->addReference(self::USERS_REFERENCE, $user);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PersonsFixtures::class,
            GendersFixtures::class,
            CitiesFixtures::class,
            PostalCodeFixtures::class,
        ];
    }
}
