<?php

namespace App\Repository;

use App\Entity\UserSubscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserSubscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSubscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSubscription[]    findAll()
 * @method UserSubscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSubscriptionRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, UserSubscription::class);

    }

}
