<?php

namespace App\DataFixtures;

use App\Entity\Publications;
use App\Entity\Users; // Assuming you have a Users entity to associate with Publications
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PublicationsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $publicationData = [
            [
                'date_publication' => new \DateTime('2023-01-01'),
                'title' => 'Un nouveau partenariat entre Fablab en Kit et la Fondation Orange Guinée',
                'description' => "Nous avons récemment collaboré avec la fondation Orange Guinée pour l ouverture d un Fablab à l ENPT (l école nationale des postes et télécommunication) de Kipé à Conakry. Ce laboratoire de fabrication pourra permettre aux étudiants de créer et d innover ainsi que pour la réalisation de travaux pratiques et l expérimentation d objets connectés. Cet atelier dispose d une découpe laser et d une partie 3d comprenant deux imprimantes 3d et deux scanners 3d. Un atelier électronique et robotique et de l outillage à main et électroportatif. Fablab en kit a fournit les équipements et la formation des enseignants à l utilisation et la maintenance des machines. Nous avons eu le plaisir de découvrir une équipe investie et curieuse de découvrir de nouveaux domaines. Le fablab de l ENPT a de beaux jours devant lui!",
                'front_picture' => '65f6e8e45aa31.webp',
                'media' => '',
                'is_published' => true,
            ],
            [
                'date_publication' => new \DateTime('2023-02-14'),
                'title' => 'Une Omniprésence de Bambulab',
                'description' => "La France Terre de l impression 3D De très nombreuses entreprises françaises du domaine de l impression 3D étaient présentes. On a remarqué des fabricants d imprimantes comme Volumic 3D (Les niçois aux imprimantes par dépôt de filaments noires et vertes ) ou Pollen (Le fabriquant des imprimantes par granulé) mais aussi de fabricants de solutions plus custom comme Cosmyx 3D (Visible avec 2 fermes d imprimantes 3D, l une à tapis roulant et l autre à bras robotisé) ou Tobeca (Venu avec une imprimante de 2 mètres par 2 mètres par 2 mètres, clairement la plus grosse machine du 3d print show).",
                'front_picture' => '65f6ebde0944a.webp',
                'media' => '',
                'is_published' => true,
            ],
            [
                'date_publication' => new \DateTime('2023-01-14'),
                'title' => 'Les FabLabs !',
                'description' => "Prensentation des FabLabs en france",
                'front_picture' => '',
                'media' => 'https://www.youtube.com/watch?v=WcVlnyCriv4',
                'is_published' => true,
            ],
            // Add more publications as needed
        ];

        foreach ($publicationData as $data) {
            $publication = new Publications();
            $publication->setDatePublication($data['date_publication'])
                        ->setTitle($data['title'])
                        ->setDescription($data['description'])
                        ->setFrontPicture($data['front_picture'])
                        ->setMedia($data['media'])
                        ->setIsPublished($data['is_published'])

                        ->setUser($this->getReference(UsersFixtures::USERS_REFERENCE));

            $manager->persist($publication);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UsersFixtures::class, // Ensure UsersFixtures is loaded first to set user references
        ];
    }
}

