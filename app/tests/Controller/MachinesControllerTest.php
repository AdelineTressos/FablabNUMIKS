<?php

// namespace App\Test\Controller;

// use App\Entity\Machines;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class MachinesControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/machines/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Machines::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Machine index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'machine[name_machine]' => 'Testing',
//             'machine[number_machine]' => 'Testing',
//             'machine[description]' => 'Testing',
//             'machine[machine_picture]' => 'Testing',
//             'machine[member_access]' => 'Testing',
//             'machine[is_booked]' => 'Testing',
//             'machine[workspace]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Machines();
//         $fixture->setNameMachine('My Title');
//         $fixture->setNumberMachine('123');
//         $fixture->setDescription('Description');
//         $fixture->setMachinePicture('/path/to/picture');
//         $fixture->setMemberAccess(true); 
//         $fixture->setIsBooked(false); 

//         // Ici, vous devez créer ou récupérer un workspace existant
//         // $workspace = ...;
//         // $fixture->setWorkspace($workspace);

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Machine');
//     }


//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Machines();
//         $fixture->setNameMachine('My Title');
//         $fixture->setNumberMachine('123');
//         $fixture->setDescription('Description');
//         $fixture->setMachinePicture('/path/to/picture');
//         $fixture->setMemberAccess(true); 
//         $fixture->setIsBooked(false);

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

//         $this->client->submitForm('Update', [
//             'machine[name_machine]' => 'Something New',
//             'machine[number_machine]' => 'Something New',
//             'machine[description]' => 'Something New',
//             'machine[machine_picture]' => 'Something New',
//             'machine[member_access]' => 'Something New',
//             'machine[is_booked]' => 'Something New',
//             'machine[workspace]' => 'Something New',
//         ]);

//         self::assertResponseRedirects('/machines/');

//         $fixture = $this->repository->findAll();

//         self::assertSame('Something New', $fixture[0]->getName_machine());
//         self::assertSame('Something New', $fixture[0]->getNumber_machine());
//         self::assertSame('Something New', $fixture[0]->getDescription());
//         self::assertSame('Something New', $fixture[0]->getMachine_picture());
//         self::assertSame('Something New', $fixture[0]->getMember_access());
//         self::assertSame('Something New', $fixture[0]->getIs_booked());
//         self::assertSame('Something New', $fixture[0]->getWorkspace());
//     }

//     public function testRemove(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Machines();
//         $fixture->setNameMachine('My Title');
//         $fixture->setNumberMachine('123');
//         $fixture->setDescription('Description');
//         $fixture->setMachinePicture('/path/to/picture');
//         $fixture->setMemberAccess(true); 
//         $fixture->setIsBooked(false);

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         $this->client->submitForm('Delete');

//         self::assertResponseRedirects('/machines/');
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
