<?php

// namespace App\Test\Controller;

// use App\Entity\Events;
// use App\Entity\Participants;
// use App\Entity\Persons;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class ParticipantsControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/participants/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Participants::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Participant index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'participant[is_validated]' => 'Testing',
//             'participant[event]' => 'Testing',
//             'participant[person]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
//         $this->markTestIncomplete();

//         // Création et configuration des entités liées, ici représentées de manière simplifiée
//         $event = new Events();
//         // Configurez $event comme nécessaire
//         $this->manager->persist($event);

//         $person = new Persons();
//         // Configurez $person comme nécessaire
//         $this->manager->persist($person);

//         $this->manager->flush(); // Assurez-vous que $event et $person sont persistés et ont des ID

//         $fixture = new Participants();
//         $fixture->setIsValidated(true); // Utilisez une valeur booléenne
//         $fixture->setEvent($event); // Associez l'entité Events
//         $fixture->setPerson($person); // Associez l'entité Persons

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Participant');
//     }


//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();
//         // Création des entités liées (Event et Person) pour les tests
//         $event = new Events();
//         // ... Configurez $event selon les besoins
//         $this->manager->persist($event);

//         $person = new Persons();
//         // ... Configurez $person selon les besoins
//         $this->manager->persist($person);

//         $this->manager->flush(); // Important pour obtenir des IDs pour $event et $person

//         $fixture = new Participants();
//         $fixture->setIsValidated(true);
//         $fixture->setEvent($event);
//         $fixture->setPerson($person);

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         // Assurez-vous de passer les bons types de données dans le formulaire
//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));
//         $this->client->submitForm('Update', [
//             'participant[is_validated]' => true,
//             'participant[event]' => $event->getId(),
//             'participant[person]' => $person->getId(),
//         ]);

//         self::assertResponseRedirects('/participants/');
//         $updatedFixture = $this->repository->find($fixture->getId());
//         self::assertTrue($updatedFixture->isIsValidated());
        
//     }


//     public function testRemove(): void
//     {
//         $event = new Events();
//         $person = new Persons(); 


//         $this->manager->persist($event);
//         $this->manager->persist($person);
//         $this->manager->flush(); 

//         $fixture = new Participants();
//         $fixture->setIsValidated(true); 
//         $fixture->setEvent($event);
//         $fixture->setPerson($person);

//         $this->manager->persist($fixture);
//         $this->manager->flush();


//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         $this->client->submitForm('Delete'); 

//         self::assertResponseRedirects('/participants/');
        
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
