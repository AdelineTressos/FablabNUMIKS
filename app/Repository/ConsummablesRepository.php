<?php

namespace App\Repository;

use App\Entity\Consummables;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Consummables>
 *
 * @method Consummables|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consummables|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consummables[]    findAll()
 * @method Consummables[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsummablesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consummables::class);
    }

    public function findByConsummableName(?string $name)
{
    $queryBuilder = $this->createQueryBuilder('c');

    if ($name) {
        $queryBuilder->where('c.name_consummable LIKE :name')
                     ->setParameter('name', '%' . $name . '%');
    }

    return $queryBuilder->getQuery()->getResult();
}


    public function findAtThreshold(): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.quantity <= c.threshold')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Consummables[] Returns an array of Consummables objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Consummables
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
