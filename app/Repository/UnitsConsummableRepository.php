<?php

namespace App\Repository;

use App\Entity\UnitsConsummable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UnitsConsummable>
 *
 * @method UnitsConsummable|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnitsConsummable|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnitsConsummable[]    findAll()
 * @method UnitsConsummable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitsConsummableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnitsConsummable::class);
    }

//    /**
//     * @return UnitsConsummable[] Returns an array of UnitsConsummable objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UnitsConsummable
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
