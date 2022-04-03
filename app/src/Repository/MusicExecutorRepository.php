<?php

namespace App\Repository;

use App\Entity\MusicExecutor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MusicExecutorRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|MusicExecutor find($id, $lockMode = null, $lockVersion = null)
 * @method null|MusicExecutor findOneBy(array $criteria, array $orderBy = null)
 * @method MusicExecutor[]    findAll()
 * @method MusicExecutor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusicExecutorRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MusicExecutor::class);
    }
}
