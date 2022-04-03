<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PlaylistRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|Playlist find($id, $lockMode = null, $lockVersion = null)
 * @method null|Playlist findOneBy(array $criteria, array $orderBy = null)
 * @method Playlist[]    findAll()
 * @method Playlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }
}
