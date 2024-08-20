<?php

namespace App\Repository;

use App\Entity\CatConsummables;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CatConsummables>
 *
 * @method CatConsummables|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatConsummables|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatConsummables[]    findAll()
 * @method CatConsummables[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatConsummablesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatConsummables::class);
    }

    
    //    /**
    //     * @return CatConsummables[] Returns an array of CatConsummables objects
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

    //    public function findOneBySomeField($value): ?CatConsummables
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
