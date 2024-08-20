<?php

// namespace App\Test\Controller;

// use App\Entity\Users;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class UsersControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/users/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Users::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('User index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'user[lastname]' => 'Testing',
//             'user[firstname]' => 'Testing',
//             'user[phone]' => 'Testing',
//             'user[email]' => 'Testing',
//             'user[is_visitor]' => 'Testing',
//             'user[username]' => 'Testing',
//             'user[roles]' => 'Testing',
//             'user[password]' => 'Testing',
//             'user[birthday]' => 'Testing',
//             'user[street]' => 'Testing',
//             'user[adress_complement]' => 'Testing',
//             'user[is_organization]' => 'Testing',
//             'user[is_email_verified]' => 'Testing',
//             'user[is_validated]' => 'Testing',
//             'user[first_membership]' => 'Testing',
//             'user[last_membership]' => 'Testing',
//             'user[num_siret]' => 'Testing',
//             'user[name_organization]' => 'Testing',
//             'user[gender]' => 'Testing',
//             'user[postalcode]' => 'Testing',
//             'user[city]' => 'Testing',
//             'user[consummable]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Users();
//         $fixture->setLastname('My Title');
//         $fixture->setFirstname('My Title');
//         $fixture->setPhone('My Title');
//         $fixture->setEmail('My Title');
//         $fixture->setIsVisitor('My Title');
//         $fixture->setUsername('My Title');
//         $fixture->setRoles('My Title');
//         $fixture->setPassword('My Title');
//         $fixture->setBirthday('My Title');
//         $fixture->setStreet('My Title');
//         $fixture->setAdressComplement('My Title');
//         $fixture->setIsOrganization('My Title');
//         $fixture->setIsEmailVerified('My Title');
//         $fixture->setIsValidated('My Title');
//         $fixture->setFirstMembership('My Title');
//         $fixture->setLastMembership('My Title');
//         $fixture->setNumSiret('My Title');
//         $fixture->setNameOrganization('My Title');
//         $fixture->setGender('My Title');
//         $fixture->setPostalcode('My Title');
//         $fixture->setCity('My Title');
//         $fixture->setConsummable('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('User');

//         // Use assertions to check that the properties are properly displayed.
//     }

//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Users();
//         $fixture->setLastname('Value');
//         $fixture->setFirstname('Value');
//         $fixture->setPhone('Value');
//         $fixture->setEmail('Value');
//         $fixture->setIsVisitor('Value');
//         $fixture->setUsername('Value');
//         $fixture->setRoles('Value');
//         $fixture->setPassword('Value');
//         $fixture->setBirthday('Value');
//         $fixture->setStreet('Value');
//         $fixture->setAdressComplement('Value');
//         $fixture->setIsOrganization('Value');
//         $fixture->setIsEmailVerified('Value');
//         $fixture->setIsValidated('Value');
//         $fixture->setFirstMembership('Value');
//         $fixture->setLastMembership('Value');
//         $fixture->setNumSiret('Value');
//         $fixture->setNameOrganization('Value');
//         $fixture->setGender('Value');
//         $fixture->setPostalcode('Value');
//         $fixture->setCity('Value');
//         $fixture->setConsummable('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

//         $this->client->submitForm('Update', [
//             'user[lastname]' => 'Something New',
//             'user[firstname]' => 'Something New',
//             'user[phone]' => 'Something New',
//             'user[email]' => 'Something New',
//             'user[is_visitor]' => 'Something New',
//             'user[username]' => 'Something New',
//             'user[roles]' => 'Something New',
//             'user[password]' => 'Something New',
//             'user[birthday]' => 'Something New',
//             'user[street]' => 'Something New',
//             'user[adress_complement]' => 'Something New',
//             'user[is_organization]' => 'Something New',
//             'user[is_email_verified]' => 'Something New',
//             'user[is_validated]' => 'Something New',
//             'user[first_membership]' => 'Something New',
//             'user[last_membership]' => 'Something New',
//             'user[num_siret]' => 'Something New',
//             'user[name_organization]' => 'Something New',
//             'user[gender]' => 'Something New',
//             'user[postalcode]' => 'Something New',
//             'user[city]' => 'Something New',
//             'user[consummable]' => 'Something New',
//         ]);

//         self::assertResponseRedirects('/users/');

//         $fixture = $this->repository->findAll();

//         self::assertSame('Something New', $fixture[0]->getLastname());
//         self::assertSame('Something New', $fixture[0]->getFirstname());
//         self::assertSame('Something New', $fixture[0]->getPhone());
//         self::assertSame('Something New', $fixture[0]->getEmail());
//         self::assertSame('Something New', $fixture[0]->getIs_visitor());
//         self::assertSame('Something New', $fixture[0]->getUsername());
//         self::assertSame('Something New', $fixture[0]->getRoles());
//         self::assertSame('Something New', $fixture[0]->getPassword());
//         self::assertSame('Something New', $fixture[0]->getBirthday());
//         self::assertSame('Something New', $fixture[0]->getStreet());
//         self::assertSame('Something New', $fixture[0]->getAdress_complement());
//         self::assertSame('Something New', $fixture[0]->getIs_organization());
//         self::assertSame('Something New', $fixture[0]->getIs_email_verified());
//         self::assertSame('Something New', $fixture[0]->getIs_validated());
//         self::assertSame('Something New', $fixture[0]->getFirst_membership());
//         self::assertSame('Something New', $fixture[0]->getLast_membership());
//         self::assertSame('Something New', $fixture[0]->getNum_siret());
//         self::assertSame('Something New', $fixture[0]->getName_organization());
//         self::assertSame('Something New', $fixture[0]->getGender());
//         self::assertSame('Something New', $fixture[0]->getPostalcode());
//         self::assertSame('Something New', $fixture[0]->getCity());
//         self::assertSame('Something New', $fixture[0]->getConsummable());
//     }

//     public function testRemove(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Users();
//         $fixture->setLastname('Value');
//         $fixture->setFirstname('Value');
//         $fixture->setPhone('Value');
//         $fixture->setEmail('Value');
//         $fixture->setIsVisitor('Value');
//         $fixture->setUsername('Value');
//         $fixture->setRoles('Value');
//         $fixture->setPassword('Value');
//         $fixture->setBirthday('Value');
//         $fixture->setStreet('Value');
//         $fixture->setAdressComplement('Value');
//         $fixture->setIsOrganization('Value');
//         $fixture->setIsEmailVerified('Value');
//         $fixture->setIsValidated('Value');
//         $fixture->setFirstMembership('Value');
//         $fixture->setLastMembership('Value');
//         $fixture->setNumSiret('Value');
//         $fixture->setNameOrganization('Value');
//         $fixture->setGender('Value');
//         $fixture->setPostalcode('Value');
//         $fixture->setCity('Value');
//         $fixture->setConsummable('Value');

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         $this->client->submitForm('Delete');

//         self::assertResponseRedirects('/users/');
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
