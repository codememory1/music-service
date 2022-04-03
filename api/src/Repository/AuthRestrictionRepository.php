<?php

namespace App\Repository;

use App\Entity\AuthRestriction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AuthRestrictionRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|AuthRestriction find($id, $lockMode = null, $lockVersion = null)
 * @method null|AuthRestriction findOneBy(array $criteria, array $orderBy = null)
 * @method AuthRestriction[]    findAll()
 * @method AuthRestriction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthRestrictionRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthRestriction::class);
    }
}
