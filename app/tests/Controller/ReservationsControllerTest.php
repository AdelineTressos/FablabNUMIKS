<?php

// namespace App\Test\Controller;

// use App\Entity\Reservations;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class ReservationsControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/reservations/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Reservations::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Reservation index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'reservation[date_reservation]' => 'Testing',
//             'reservation[start_hour]' => 'Testing',
//             'reservation[end_hour]' => 'Testing',
//             'reservation[is_validated]' => 'Testing',
//             'reservation[state_reservation]' => 'Testing',
//             'reservation[event]' => 'Testing',
//             'reservation[workspace]' => 'Testing',
//             'reservation[machine]' => 'Testing',
//             'reservation[user]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Reservations();
//         $fixture->setDateReservation('My Title');
//         $fixture->setStartHour('My Title');
//         $fixture->setEndHour('My Title');
//         $fixture->setIsValidated('My Title');
//         $fixture->setStateReservation('My Title');
//         $fixture->setEvent('My Title');
//         $fixture->setWorkspace('My Title');
//         $fixture->setMachine('My Title');
//         $fixture->setUser('My Title');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Reservation');

//         // Use assertions to check that the properties are properly displayed.
//     }

//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Reservations();
//         $fixture->setDateReservation('Value');
//         $fixture->setStartHour('Value');
//         $fixture->setEndHour('Value');
//         $fixture->setIsValidated('Value');
//         $fixture->setStateReservation('Value');
//         $fixture->setEvent('Value');
//         $fixture->setWorkspace('Value');
//         $fixture->setMachine('Value');
//         $fixture->setUser('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

//         $this->client->submitForm('Update', [
//             'reservation[date_reservation]' => 'Something New',
//             'reservation[start_hour]' => 'Something New',
//             'reservation[end_hour]' => 'Something New',
//             'reservation[is_validated]' => 'Something New',
//             'reservation[state_reservation]' => 'Something New',
//             'reservation[event]' => 'Something New',
//             'reservation[workspace]' => 'Something New',
//             'reservation[machine]' => 'Something New',
//             'reservation[user]' => 'Something New',
//         ]);

//         self::assertResponseRedirects('/reservations/');

//         $fixture = $this->repository->findAll();

//         self::assertSame('Something New', $fixture[0]->getDate_reservation());
//         self::assertSame('Something New', $fixture[0]->getStart_hour());
//         self::assertSame('Something New', $fixture[0]->getEnd_hour());
//         self::assertSame('Something New', $fixture[0]->getIs_validated());
//         self::assertSame('Something New', $fixture[0]->getState_reservation());
//         self::assertSame('Something New', $fixture[0]->getEvent());
//         self::assertSame('Something New', $fixture[0]->getWorkspace());
//         self::assertSame('Something New', $fixture[0]->getMachine());
//         self::assertSame('Something New', $fixture[0]->getUser());
//     }

//     public function testRemove(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Reservations();
//         $fixture->setDateReservation('Value');
//         $fixture->setStartHour('Value');
//         $fixture->setEndHour('Value');
//         $fixture->setIsValidated('Value');
//         $fixture->setStateReservation('Value');
//         $fixture->setEvent('Value');
//         $fixture->setWorkspace('Value');
//         $fixture->setMachine('Value');
//         $fixture->setUser('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         $this->client->submitForm('Delete');

//         self::assertResponseRedirects('/reservations/');
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
