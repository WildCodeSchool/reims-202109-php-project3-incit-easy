<?php

namespace App\Repository;

use App\Entity\Garbage;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Garbage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Garbage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Garbage[]    findAll()
 * @method Garbage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GarbageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Garbage::class);
    }

    // /**
    //  * @return Garbage[] Returns an array of Garbage objects
    //  */

    public function findByWeek(DateTime $value, User $user): mixed
    {
        return $this->createQueryBuilder('g')
            ->andWhere('date_diff(date_add(:val, (6 - weekday(:val)), \'day\'),
            g.createdAt) < 7')
            ->andWhere('date_diff(date_add(:val, (6 - weekday(:val)), \'day\'),
            g.createdAt) >= 0')
            ->andWhere('g.user = :user')
            ->setParameter('val', $value)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByYear(DateTime $value, User $user): mixed
    {
        return $this->createQueryBuilder('g')
            ->andWhere('SUBSTRING(g.createdAt, 1, 4) = SUBSTRING(:val, 1, 4)')
            ->andWhere('g.createdAt <= :val')
            ->andWhere('g.user = :user')
            ->setParameter('val', $value)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Garbage
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
