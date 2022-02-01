<?php

namespace App\Repository;

use App\Entity\LanguageTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LanguageTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method LanguageTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method LanguageTranslation[]    findAll()
 * @method LanguageTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LanguageTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LanguageTranslation::class);
    }

    // /**
    //  * @return LanguageTranslation[] Returns an array of LanguageTranslation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LanguageTranslation
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
