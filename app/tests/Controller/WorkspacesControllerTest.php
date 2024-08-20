<?php

// namespace App\Test\Controller;

// use App\Entity\Workspaces;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class WorkspacesControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/workspaces/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Workspaces::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Workspace index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'workspace[name_workspace]' => 'Testing',
//             'workspace[description]' => 'Testing',
//             'workspace[member_access]' => 'Testing',
//             'workspace[is_booked]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Workspaces();
//         $fixture->setName_workspace('My Title');
//         $fixture->setDescription('My Title');
//         $fixture->setMember_access('My Title');
//         $fixture->setIs_booked('My Title');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Workspace');

//         // Use assertions to check that the properties are properly displayed.
//     }

//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Workspaces();
//         $fixture->setNameWorkspace('Value');
//         $fixture->setDescription('Value');
//         $fixture->setMemberAccess('Value');
//         $fixture->setIsBooked('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

//         $this->client->submitForm('Update', [
//             'workspace[name_workspace]' => 'Something New',
//             'workspace[description]' => 'Something New',
//             'workspace[member_access]' => 'Something New',
//             'workspace[is_booked]' => 'Something New',
//         ]);

//         self::assertResponseRedirects('/workspaces/');

//         $fixture = $this->repository->findAll();

//         self::assertSame('Something New', $fixture[0]->getName_workspace());
//         self::assertSame('Something New', $fixture[0]->getDescription());
//         self::assertSame('Something New', $fixture[0]->getMember_access());
//         self::assertSame('Something New', $fixture[0]->getIs_booked());
//     }

//     public function testRemove(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Workspaces();
//         $fixture->setNameWorkspace('Value');
//         $fixture->setDescription('Value');
//         $fixture->setMemberAccess('Value');
//         $fixture->setIsBooked('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         $this->client->submitForm('Delete');

//         self::assertResponseRedirects('/workspaces/');
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
