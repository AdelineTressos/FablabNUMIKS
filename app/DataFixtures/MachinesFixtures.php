<?php

namespace App\DataFixtures;

use App\Entity\Machines;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MachinesFixtures extends Fixture implements DependentFixtureInterface
{
    public const MACHINE_REFERENCE = 'machine';
    public function load(ObjectManager $manager): void
    {
        $machinesData = [
            [
                'name_machine' => '3D Printer',
                'number_machine' => '3DP-001',
                'description' => 'High precision 3D printer.',
                'machine_picture' => 'path/to/3dprinter.jpg',
                'member_access' => true,
                'is_booked' => false, 
            ],
            [
                'name_machine' => 'CNC Machine',
                'number_machine' => 'CNC-002',
                'description' => 'Advanced CNC milling machine.',
                'machine_picture' => 'path/to/cncmachine.jpg',
                'member_access' => false,
                'is_booked' => true,
            ],
            // Ajoutez plus de données de machines selon le besoin
        ];

        foreach ($machinesData as $data) {
            $machine = new Machines();
            $machine->setNameMachine($data['name_machine'])
                    ->setNumberMachine($data['number_machine'])
                    ->setDescription($data['description'])
                    ->setMachinePicture($data['machine_picture'])
                    ->setMemberAccess($data['member_access'])
                    ->setIsBooked($data['is_booked'])
                    
                    ->setWorkspace($this->getReference(WorkspacesFixtures::WORKSPACES_REFERENCE)); 

            $manager->persist($machine);
        }
        $this->addReference(self::MACHINE_REFERENCE, $machine);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            WorkspacesFixtures::class, // Assurez-vous que WorkspacesFixtures est chargé en premier pour définir les références de l'espace de travail
        ];
    }
}
