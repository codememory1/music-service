<?php

namespace App\Repository;

use App\Entity\UserProfileCover;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProfileCover|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProfileCover|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProfileCover[]    findAll()
 * @method UserProfileCover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProfileCoverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProfileCover::class);
    }

    // /**
    //  * @return UserProfileCover[] Returns an array of UserProfileCover objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserProfileCover
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
