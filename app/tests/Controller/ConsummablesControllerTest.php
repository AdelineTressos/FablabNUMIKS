<?php

// namespace App\Test\Controller;

// use App\Entity\CatConsummables;
// use App\Entity\Consummables;
// use App\Entity\UnitsConsummable;
// use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityRepository;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class ConsummablesControllerTest extends WebTestCase
// {
//     private KernelBrowser $client;
//     private EntityManagerInterface $manager;
//     private EntityRepository $repository;
//     private string $path = '/consummables/';

//     protected function setUp(): void
//     {
//         $this->client = static::createClient();
//         $this->manager = static::getContainer()->get('doctrine')->getManager();
//         $this->repository = $this->manager->getRepository(Consummables::class);

//         foreach ($this->repository->findAll() as $object) {
//             $this->manager->remove($object);
//         }

//         $this->manager->flush();
//     }

//     public function testIndex(): void
//     {
//         $crawler = $this->client->request('GET', $this->path);

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Consummable index');

//         // Use the $crawler to perform additional assertions e.g.
//         // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
//     }

//     public function testNew(): void
//     {
//         $this->markTestIncomplete();
//         $this->client->request('GET', sprintf('%snew', $this->path));

//         self::assertResponseStatusCodeSame(200);

//         $this->client->submitForm('Save', [
//             'consummable[name_consummable]' => 'Testing',
//             'consummable[quantity]' => 'Testing',
//             'consummable[threshold]' => 'Testing',
//             'consummable[cat_consummables]' => 'Testing',
//             'consummable[unit_consummables]' => 'Testing',
//         ]);

//         self::assertResponseRedirects($this->path);

//         self::assertSame(1, $this->repository->count([]));
//     }

//     public function testShow(): void
//     {
//         $this->markTestIncomplete();
//         $fixture = new Consummables();
//         $fixture->setNameConsummable('My Title');
//         $fixture->setQuantity(10.0); // Assurez-vous que c'est un float
//         $fixture->setThreshold(5.0); // Assurez-vous que c'est un float

//         // Supposons que $catConsummable et $unitConsummable sont des instances valides de CatConsummables et UnitsConsummable
//         $catConsummable = new CatConsummables(); // Vous devez configurer cet objet correctement
//         $unitConsummable = new UnitsConsummable(); // Vous devez configurer cet objet correctement
//         $fixture->setCatConsummables($catConsummable);
//         $fixture->setUnitConsummables($unitConsummable);

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

//         self::assertResponseStatusCodeSame(200);
//         self::assertPageTitleContains('Consummable');

//         // Utilisez des assertions pour vérifier que les propriétés sont correctement affichées.
//     }


//     public function testEdit(): void
//     {
//         $this->markTestIncomplete();

//         // Préparation de l'objet Consummable
//         $fixture = new Consummables();
//         $fixture->setNameConsummable('Initial Value');
//         $fixture->setQuantity(10.0); // Valeur initiale
//         $fixture->setThreshold(5.0); // Valeur initiale

//         // Ici, vous devez créer ou trouver des entités existantes pour CatConsummables et UnitsConsummable
//         // Pour l'exemple, les entités sont simplement instanciées (en réalité, vous pourriez vouloir les récupérer depuis la base de données)
//         $catConsummable = new CatConsummables(); // Assurez-vous que cette entité est correctement configurée
//         $unitConsummable = new UnitsConsummable(); // Assurez-vous que cette entité est correctement configurée

//         $fixture->setCatConsummables($catConsummable);
//         $fixture->setUnitConsummables($unitConsummable);

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

//         // Simulez la soumission d'un formulaire avec des valeurs mises à jour
//         $this->client->submitForm('Update', [
//             'consummable[name_consummable]' => 'Something New',
//             'consummable[quantity]' => 20.0, // Mise à jour
//             'consummable[threshold]' => 10.0, // Mise à jour
//             // Pour cat_consummables et unit_consummables, vous devez soumettre des identifiants d'entités existantes, pas des chaînes
//         ]);

//         self::assertResponseRedirects('/consummables/');

//         // Récupérez le consummable mis à jour pour vérification
//         $updatedFixture = $this->repository->find($fixture->getId());

//         self::assertSame('Something New', $updatedFixture->getNameConsummable());
//         self::assertSame(20.0, $updatedFixture->getQuantity());
//         self::assertSame(10.0, $updatedFixture->getThreshold());
//         // Ici, vous devriez également vérifier les associations avec CatConsummables et UnitsConsummable si nécessaire
//     }


//     public function testRemove(): void
//     {
//         $this->markTestIncomplete();

//         $fixture = new Consummables();
//         $fixture->setNameConsummable('To Be Deleted');
//         $fixture->setQuantity(10.0);
//         $fixture->setThreshold(5.0);
//         // Assurez-vous d'assigner des objets CatConsummables et UnitsConsummable valides si nécessaire

//         $this->manager->persist($fixture);
//         $this->manager->flush();

//         // Effectuez une requête GET pour charger la page de suppression, si nécessaire
//         $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
//         // Soumettez le formulaire de suppression, cela peut nécessiter d'adapter selon l'implémentation réelle de votre application
//         $this->client->submitForm('Delete');

//         self::assertResponseRedirects('/consummables/');
//         self::assertSame(0, $this->repository->count([]));
//     }
// }
