<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @implements PasswordUpgraderInterface<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    // All Members is_validated = false
    public function findAllUsersNonValidatedNonVisitors(): array
    {
        return $this->createQueryBuilder('u')

                    ->where('u.is_validated = :is_validated')
                    ->setParameter('is_validated', false)
                    ->andWhere('u.is_visitor = :is_visitor OR u.is_visitor IS NULL')
                    ->setParameter('is_visitor', false)
                    ->getQuery()
                    ->getResult();
    }

    public function countTotalMembers(): int {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.is_validated = :is_validated')
            ->setParameter('is_validated', true)
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_USER"%')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findUsersEndingMembership(): array
    {
        $dateInOneMonth = new \DateTime('+1 month');

        return $this->createQueryBuilder('u')
            ->where('u.last_membership <= :dateInOneMonth')
            ->andWhere('u.is_validated = :is_validated')
            ->setParameter('dateInOneMonth', $dateInOneMonth->modify('-1 year'))
            ->setParameter('is_validated', true)
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Users[] Returns an array of Users objects
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

    //    public function findOneBySomeField($value): ?Users
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
   
}
