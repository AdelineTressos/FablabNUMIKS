<?php

// namespace App\Test\Controller;

// use App\Entity\Persons;
// use App\Entity\Genders;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class PersonsControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/persons/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Persons::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Person index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'person[lastname]' => 'Testing',
//             'person[firstname]' => 'Testing',
//             'person[phone]' => 'Testing',
//             'person[email]' => 'Testing',
//             'person[is_visitor]' => 'Testing',
//             'person[gender]' => 'Testing',
//             'person[postalcode]' => 'Testing',
//             'person[city]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
        
//         $this->markTestIncomplete();
//         $fixture = new Persons();
//         $fixture->setLastname('My Title');
//         $fixture->setFirstname('My Title');
//         $fixture->setPhone('My Title');
//         $fixture->setEmail('My Title');
//         $fixture->isIsVisitor('My Title');
//         $fixture->setGender('My Title');
//         $fixture->setPostalcode('My Title');
//         $fixture->setCity('My Title');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Person');

//         // Use assertions to check that the properties are properly displayed.
//     }

//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Persons();
//         $fixture->setLastname('Value');
//         $fixture->setFirstname('Value');
//         $fixture->setPhone('Value');
//         $fixture->setEmail('Value');
//         $fixture->setIsVisitor('Value');
//         $fixture->setGender('Value');
//         $fixture->setPostalcode('Value');
//         $fixture->setCity('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

//         $this->client->submitForm('Update', [
//             'person[lastname]' => 'Something New',
//             'person[firstname]' => 'Something New',
//             'person[phone]' => 'Something New',
//             'person[email]' => 'Something New',
//             'person[is_visitor]' => 'Something New',
//             'person[gender]' => 'Something New',
//             'person[postalcode]' => 'Something New',
//             'person[city]' => 'Something New',
//         ]);

//         self::assertResponseRedirects('/persons/');

//         $fixture = $this->repository->findAll();

//         self::assertSame('Something New', $fixture[0]->getLastname());
//         self::assertSame('Something New', $fixture[0]->getFirstname());
//         self::assertSame('Something New', $fixture[0]->getPhone());
//         self::assertSame('Something New', $fixture[0]->getEmail());
//         self::assertSame('Something New', $fixture[0]->getIs_visitor());
//         self::assertSame('Something New', $fixture[0]->getGender());
//         self::assertSame('Something New', $fixture[0]->getPostalcode());
//         self::assertSame('Something New', $fixture[0]->getCity());
//     }

//     public function testRemove(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Persons();
//         $fixture->setLastname('Value');
//         $fixture->setFirstname('Value');
//         $fixture->setPhone('Value');
//         $fixture->setEmail('Value');
//         $fixture->setIsVisitor('Value');
//         $fixture->setGender('Value');
//         $fixture->setPostalcode('Value');
//         $fixture->setCity('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         $this->client->submitForm('Delete');

//         self::assertResponseRedirects('/persons/');
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
