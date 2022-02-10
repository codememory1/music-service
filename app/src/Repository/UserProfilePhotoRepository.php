<?php

namespace App\Repository;

use App\Entity\UserProfilePhoto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProfilePhoto|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProfilePhoto|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProfilePhoto[]    findAll()
 * @method UserProfilePhoto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProfilePhotoRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, UserProfilePhoto::class);

    }

}
