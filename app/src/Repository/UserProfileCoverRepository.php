<?php

namespace App\Repository;

use App\Entity\UserProfileCover;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProfileCover|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProfileCover|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProfileCover[]    findAll()
 * @method UserProfileCover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProfileCoverRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, UserProfileCover::class);

    }

}
