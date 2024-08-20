<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Contact;

class ContactTest extends KernelTestCase
{

    public function getEntityContact() : Contact
    {
        return(new Contact())->setLastname('Nom #1')
        ->setFirstname('Prénom #1')
        ->setEmail('nom.prenom1@email.com')
        ->setPhone('0666666666')
        ->setMessage('Message #1')
        ->setCreatedAt(new \DateTimeImmutable());

    }

    public function testContactEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $contact = $this->getEntityContact();

        $errors = $container->get('validator')->validate($contact);
        $this->assertCount(0, $errors);
    }

    // public function testInvalidLastname()
    // {
    //     self::bootKernel();
    //     $container = static::getContainer();    
        
    //     $contact = $this->getEntityContact();
    //     $contact->setLastname('e');

    //     $errors = $container->get('validator')->validate($contact);
    //     $this->assertCount(0, $errors);
    // }

    // public function testInvalidFirstname()
    // {
    //     self::bootKernel();
    //     $container = static::getContainer();    
        
    //     $contact = $this->getEntityContact();
    //     $contact->setFirstname('e');

    //     $errors = $container->get('validator')->validate($contact);
    //     $this->assertCount(1, $errors);
    // }

    // public function testInvalidEmailBlanck()
    // {
    //     self::bootKernel();
    //     $container = static::getContainer();    
        
    //     $contact = $this->getEntityContact();
    //     $contact->setEmail('');

    //     $errors = $container->get('validator')->validate($contact);
    //     $this->assertCount(2, $errors);
    // }

    // public function testInvalidEmail()
    // {
    //     self::bootKernel();
    //     $container = static::getContainer();    
        
    //     $contact = $this->getEntityContact();
    //     $contact->setEmail('e');

    //     $errors = $container->get('validator')->validate($contact);
    //     $this->assertCount(2, $errors);
    // }

    // public function testInvalidMessageBlanck()
    // {
    //     self::bootKernel();
    //     $container = static::getContainer();    
        
    //     $contact = $this->getEntityContact();
    //     $contact->setMessage('');

    //     $errors = $container->get('validator')->validate($contact);
    //     $this->assertCount(1, $errors);
    // }
}
