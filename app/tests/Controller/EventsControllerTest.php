<?php

// namespace App\Test\Controller;

// use App\Entity\Events;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class EventsControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/events/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Events::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Event index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'event[name_event]' => 'Testing',
//             'event[start_date]' => 'Testing',
//             'event[end_date]' => 'Testing',
//             'event[start_hour]' => 'Testing',
//             'event[end_hour]' => 'Testing',
//             'event[description]' => 'Testing',
//             'event[front_media]' => 'Testing',
//             'event[is_published]' => 'Testing',
//             'event[is_member_only]' => 'Testing',
//             'event[max_participants]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Events();
//         $fixture->setNameEvent('My Title');
//         $fixture->setStartDate(new \DateTime('2022-01-01'));
//         $fixture->setEndDate(new \DateTime('2022-01-02'));
//         $fixture->setStartHour('10:00');
//         $fixture->setEndHour('15:00');
//         $fixture->setDescription('Description of the event');
//         $fixture->setFrontMedia('/path/to/media');
//         $fixture->setIsPublished(true);
//         $fixture->setIsMemberOnly(false);
//         $fixture->setMaxParticipants(100);        

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Event');

//         // Use assertions to check that the properties are properly displayed.
//     }

//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Events();
//         $fixture->setNameEvent('My Title');
//         $fixture->setStartDate(new \DateTime('2022-01-01'));
//         $fixture->setEndDate(new \DateTime('2022-01-02'));
//         $fixture->setStartHour('10:00');
//         $fixture->setEndHour('15:00');
//         $fixture->setDescription('Description of the event');
//         $fixture->setFrontMedia('/path/to/media');
//         $fixture->setIsPublished(true);
//         $fixture->setIsMemberOnly(false);
//         $fixture->setMaxParticipants(100);
        

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

//         $this->client->submitForm('Update', [
//             'event[name_event]' => 'Something New',
//             'event[start_date]' => 'Something New',
//             'event[end_date]' => 'Something New',
//             'event[start_hour]' => 'Something New',
//             'event[end_hour]' => 'Something New',
//             'event[description]' => 'Something New',
//             'event[front_media]' => 'Something New',
//             'event[is_published]' => 'Something New',
//             'event[is_member_only]' => 'Something New',
//             'event[max_participants]' => 'Something New',
//         ]);

//         self::assertResponseRedirects('/events/');

//         $fixture = $this->repository->findAll();

//         self::assertSame('Something New', $fixture[0]->getName_event());
//         self::assertSame('Something New', $fixture[0]->getStart_date());
//         self::assertSame('Something New', $fixture[0]->getEnd_date());
//         self::assertSame('Something New', $fixture[0]->getStart_hour());
//         self::assertSame('Something New', $fixture[0]->getEnd_hour());
//         self::assertSame('Something New', $fixture[0]->getDescription());
//         self::assertSame('Something New', $fixture[0]->getFront_media());
//         self::assertSame('Something New', $fixture[0]->getIs_published());
//         self::assertSame('Something New', $fixture[0]->getIs_member_only());
//         self::assertSame('Something New', $fixture[0]->getMax_participants());
//     }

//     public function testRemove(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Events();
//         $fixture->setNameEvent('My Title');
//         $fixture->setStartDate(new \DateTime('2022-01-01'));
//         $fixture->setEndDate(new \DateTime('2022-01-02'));
//         $fixture->setStartHour('10:00');
//         $fixture->setEndHour('15:00');
//         $fixture->setDescription('Description of the event');
//         $fixture->setFrontMedia('/path/to/media');
//         $fixture->setIsPublished(true);
//         $fixture->setIsMemberOnly(false);
//         $fixture->setMaxParticipants(100);
        

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         $this->client->submitForm('Delete');

//         self::assertResponseRedirects('/events/');
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
