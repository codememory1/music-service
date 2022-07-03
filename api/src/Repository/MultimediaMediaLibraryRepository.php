<?php

namespace App\Repository;

use App\Entity\MultimediaMediaLibrary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MultimediaMediaLibrary>
 *
 * @method null|MultimediaMediaLibrary find($id, $lockMode = null, $lockVersion = null)
 * @method null|MultimediaMediaLibrary findOneBy(array $criteria, array $orderBy = null)
 * @method MultimediaMediaLibrary[]    findAll()
 * @method MultimediaMediaLibrary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MultimediaMediaLibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MultimediaMediaLibrary::class);
    }

    public function add(MultimediaMediaLibrary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MultimediaMediaLibrary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MultimediaMediaLibrary[] Returns an array of MultimediaMediaLibrary objects
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

//    public function findOneBySomeField($value): ?MultimediaMediaLibrary
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
