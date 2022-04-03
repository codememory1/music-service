<?php

namespace App\Repository;

use App\Entity\UserActivationToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserActivationTokenRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|UserActivationToken find($id, $lockMode = null, $lockVersion = null)
 * @method null|UserActivationToken findOneBy(array $criteria, array $orderBy = null)
 * @method UserActivationToken[]    findAll()
 * @method UserActivationToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserActivationTokenRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserActivationToken::class);
    }
}
