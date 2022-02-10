<?php

namespace App\Repository;

use App\Entity\UserActivationToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserActivationToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserActivationToken|null findOneBy(array $criteria, array $orderBy = null)
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
