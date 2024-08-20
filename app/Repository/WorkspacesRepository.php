<?php
namespace App\Repository;

use App\Entity\Workspaces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Workspaces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workspaces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workspaces[]    findAll()
 * @method Workspaces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkspacesRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Workspaces::class);
        $this->entityManager = $entityManager;
    }

    public function deleteWithRelations(Workspaces $workspace)
{
    // Suppression des réservations directement liées au workspace
    foreach ($workspace->getReservations() as $reservation) {
        $this->entityManager->remove($reservation);
    }

    // Suppression des réservations liées aux machines de cet espace et des machines elles-mêmes
    foreach ($workspace->getMachines() as $machine) {
        foreach ($machine->getReservations() as $reservation) {
            $this->entityManager->remove($reservation);
        }
        $this->entityManager->remove($machine);
    }

    // Suppression de l'espace de travail lui-même
    $this->entityManager->remove($workspace);
    $this->entityManager->flush();
}

}
