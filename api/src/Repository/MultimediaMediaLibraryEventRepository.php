<?php

namespace App\Repository;

use App\Entity\MultimediaMediaLibraryEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MultimediaMediaLibraryEvent>
 *
 * @method null|MultimediaMediaLibraryEvent find($id, $lockMode = null, $lockVersion = null)
 * @method null|MultimediaMediaLibraryEvent findOneBy(array $criteria, array $orderBy = null)
 * @method MultimediaMediaLibraryEvent[]    findAll()
 * @method MultimediaMediaLibraryEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MultimediaMediaLibraryEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MultimediaMediaLibraryEvent::class);
    }

    public function add(MultimediaMediaLibraryEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MultimediaMediaLibraryEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MultimediaMediaLibraryEvent[] Returns an array of MultimediaMediaLibraryEvent objects
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

//    public function findOneBySomeField($value): ?MultimediaMediaLibraryEvent
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
