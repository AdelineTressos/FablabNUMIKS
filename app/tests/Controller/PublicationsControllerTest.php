<?php

// namespace App\Test\Controller;

// use App\Entity\Publications;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class PublicationsControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/publications/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Publications::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Publication index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'publication[date_publication]' => 'Testing',
//             'publication[title]' => 'Testing',
//             'publication[description]' => 'Testing',
//             'publication[front_picture]' => 'Testing',
//             'publication[media]' => 'Testing',
//             'publication[is_published]' => 'Testing',
//             'publication[user]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Publications();
//         $fixture->setDatePublication('My Title');
//         $fixture->setTitle('My Title');
//         $fixture->setDescription('My Title');
//         $fixture->setFrontPicture('My Title');
//         $fixture->setMedia('My Title');
//         $fixture->setIsPublished('My Title');
//         $fixture->setUser('My Title');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Publication');

//         // Use assertions to check that the properties are properly displayed.
//     }

//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Publications();
//         $fixture->setDatePublication('Value');
//         $fixture->setTitle('Value');
//         $fixture->setDescription('Value');
//         $fixture->setFrontPicture('Value');
//         $fixture->setMedia('Value');
//         $fixture->setIsPublished('Value');
//         $fixture->setUser('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

//         $this->client->submitForm('Update', [
//             'publication[date_publication]' => 'Something New',
//             'publication[title]' => 'Something New',
//             'publication[description]' => 'Something New',
//             'publication[front_picture]' => 'Something New',
//             'publication[media]' => 'Something New',
//             'publication[is_published]' => 'Something New',
//             'publication[user]' => 'Something New',
//         ]);

//         self::assertResponseRedirects('/publications/');

//         $fixture = $this->repository->findAll();

//         self::assertSame('Something New', $fixture[0]->getDate_publication());
//         self::assertSame('Something New', $fixture[0]->getTitle());
//         self::assertSame('Something New', $fixture[0]->getDescription());
//         self::assertSame('Something New', $fixture[0]->getFront_picture());
//         self::assertSame('Something New', $fixture[0]->getMedia());
//         self::assertSame('Something New', $fixture[0]->getIs_published());
//         self::assertSame('Something New', $fixture[0]->getUser());
//     }

//     public function testRemove(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Publications();
//         $fixture->setDatePublication('Value');
//         $fixture->setTitle('Value');
//         $fixture->setDescription('Value');
//         $fixture->setFrontPicture('Value');
//         $fixture->setMedia('Value');
//         $fixture->setIsPublished('Value');
//         $fixture->setUser('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         $this->client->submitForm('Delete');

//         self::assertResponseRedirects('/publications/');
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
