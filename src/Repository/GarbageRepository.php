<?php

namespace App\Repository;

use App\Entity\Garbage;
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

    public function findByWeek(DateTime $value): mixed
    {
        return $this->createQueryBuilder('g')
            ->andWhere('date_diff(date_add(:val, (6 - weekday(:val)), \'day\'),
            g.createdAt) < 7')
            ->setParameter('val', $value)
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
