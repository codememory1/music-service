<?php

namespace App\Repository;

use App\Entity\SubscriptionPermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SubscriptionPermissionRepository
 *
 * @author Codememory
 *
 * @method SubscriptionPermission|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriptionPermission|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriptionPermission[]    findAll()
 * @method SubscriptionPermission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionPermissionRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, SubscriptionPermission::class);

    }

}
