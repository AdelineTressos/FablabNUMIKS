<?php

namespace App\Tests\Entity;

use App\Entity\Persons;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonsTest extends KernelTestCase
{

    public function getEntityPerson() : Persons
    {
        return(new Persons())->setLastname('Nom #1')
        ->setFirstname('Prénom #1')
        ->setEmail('nom.prenom1@email.com')
        ->setPhone('0666666666')
        ->setIsVisitor(true)
        ;

    }

    public function testPersonEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $person = $this->getEntityPerson();

        $errors = $container->get('validator')->validate($person);
        $this->assertCount(0, $errors);

    }
}
