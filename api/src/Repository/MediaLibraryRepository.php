<?php

namespace App\Repository;

use App\Entity\MediaLibrary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MediaLibraryRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|MediaLibrary find($id, $lockMode = null, $lockVersion = null)
 * @method null|MediaLibrary findOneBy(array $criteria, array $orderBy = null)
 * @method MediaLibrary[]    findAll()
 * @method MediaLibrary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaLibraryRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaLibrary::class);
    }
}
