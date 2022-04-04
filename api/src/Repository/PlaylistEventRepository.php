<?php

namespace App\Repository;

use App\Entity\PlaylistEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PlaylistEventRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|PlaylistEvent find($id, $lockMode = null, $lockVersion = null)
 * @method null|PlaylistEvent findOneBy(array $criteria, array $orderBy = null)
 * @method PlaylistEvent[]    findAll()
 * @method PlaylistEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistEventRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaylistEvent::class);
    }
}
