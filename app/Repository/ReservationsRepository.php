<?php

namespace App\Repository;

use App\Entity\Reservations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservations>
 *
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    public function countTotalReservations(): int
    {
        return $this->createQueryBuilder('r')
            ->select('count(r.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findUpcomingReservations(): array
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('r')
            ->where('r.date_reservation >= :today')
            ->setParameter('today', $today)
            ->getQuery()
            ->getResult();
    }

    public function countReservationsByMachine(): array
    {
        // Assurez-vous que 'm' est l'alias correct pour la table des machines dans votre relation
        return $this->createQueryBuilder('r')
            ->select('m.name_machine as machineName, COUNT(r.id) as reservationCount')
            ->join('r.machine', 'm')
            ->groupBy('m.name_machine')
            ->orderBy('reservationCount', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findPendingValidations(): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.is_validated = :is_validated')
            ->setParameter('is_validated', false)
            ->getQuery()
            ->getResult();
    }


    public function findReservations(?string $month, ?string $username)
    {
        $qb = $this->createQueryBuilder('r')
            ->leftJoin('r.user', 'u');

        if ($username) {
            $qb->andWhere('u.username LIKE :username')
                ->setParameter('username', '%' . $username . '%');
        }

        $reservations = $qb->getQuery()->getResult();

        // Filtre par mois dans PHP
        if ($month) {
            $reservations = array_filter($reservations, function ($reservation) use ($month) {
                return $reservation->getDateReservation()->format('m') == $month;
            });
        }

        return $reservations;
    }

    public function findAllOrderedByDate()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.date_reservation', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByUsername(string $username = null)
    {
        $qb = $this->createQueryBuilder('r')
            ->join('r.user', 'u')
            ->where('LOWER(u.username) LIKE :username')
            ->setParameter('username', '%' . strtolower($username) . '%')
            ->orderBy('r.date_reservation', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function findTodayReservations()
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('r')
            ->where('r.date_reservation = :today')
            ->setParameter('today', $today->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }

    public function findReservationsForToday()
    {
        $todayStart = new \DateTime();
        $todayStart->setTime(0, 0, 0); // Début de la journée

        $todayEnd = new \DateTime();
        $todayEnd->setTime(23, 59, 59); // Fin de la journée

        return $this->createQueryBuilder('r')
            ->where('r.date_reservation BETWEEN :start AND :end')
            ->setParameter('start', $todayStart)
            ->setParameter('end', $todayEnd)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Reservations[] Returns an array of Reservations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservations
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
