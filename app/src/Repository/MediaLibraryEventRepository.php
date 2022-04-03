<?php

namespace App\Repository;

use App\Entity\MediaLibraryEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MediaLibraryEventRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|MediaLibraryEvent find($id, $lockMode = null, $lockVersion = null)
 * @method null|MediaLibraryEvent findOneBy(array $criteria, array $orderBy = null)
 * @method MediaLibraryEvent[]    findAll()
 * @method MediaLibraryEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediaLibraryEventRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MediaLibraryEvent::class);
    }
}
