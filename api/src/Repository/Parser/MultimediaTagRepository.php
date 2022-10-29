<?php

namespace App\Repository\Parser;

use App\Entity\Parser\MultimediaTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MultimediaTag>
 *
 * @method null|MultimediaTag find($id, $lockMode = null, $lockVersion = null)
 * @method null|MultimediaTag findOneBy(array $criteria, array $orderBy = null)
 * @method MultimediaTag[]    findAll()
 * @method MultimediaTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MultimediaTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MultimediaTag::class);
    }

    public function add(MultimediaTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MultimediaTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MultimediaTag[] Returns an array of MultimediaTag objects
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

//    public function findOneBySomeField($value): ?MultimediaTag
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
