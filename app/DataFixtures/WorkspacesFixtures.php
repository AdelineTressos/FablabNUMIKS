<?php

namespace App\DataFixtures;

use App\Entity\Workspaces;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorkspacesFixtures extends Fixture
{
    public const WORKSPACES_REFERENCE = 'workspace';
    public function load(ObjectManager $manager): void
    {
        $workspacesData = [
            [
                'name_workspace' => 'Creative Hub',
                'description' => 'A space for creative minds to collaborate.',
                'member_access' => true,
                'is_booked' => false,
            ],
            [
                'name_workspace' => 'Tech Lab',
                'description' => 'Equipped with the latest tech for innovation.',
                'member_access' => false,
                'is_booked' => false,
            ],
            [
                'name_workspace' => 'Quiet Zone',
                'description' => 'A peaceful spot for focus and productivity.',
                'member_access' => true,
                'is_booked' => true,
            ],
        ];

        foreach ($workspacesData as $workspaceData) {
            $workspace = new Workspaces();
            $workspace->setNameWorkspace($workspaceData['name_workspace'])
                      ->setDescription($workspaceData['description'])
                      ->setMemberAccess($workspaceData['member_access'])
                      ->setIsBooked($workspaceData['is_booked']);

            $manager->persist($workspace);
        }
        $this->addReference(self::WORKSPACES_REFERENCE, $workspace);
        $manager->flush();
    }
}
