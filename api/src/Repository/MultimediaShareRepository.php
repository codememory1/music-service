<?php

namespace App\Repository;

use App\Entity\MultimediaShare;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MultimediaShare>
 *
 * @method null|MultimediaShare find($id, $lockMode = null, $lockVersion = null)
 * @method null|MultimediaShare findOneBy(array $criteria, array $orderBy = null)
 * @method MultimediaShare[]    findAll()
 * @method MultimediaShare[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MultimediaShareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MultimediaShare::class);
    }

    public function add(MultimediaShare $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MultimediaShare $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MultimediaShare[] Returns an array of MultimediaShare objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MultimediaShare
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
