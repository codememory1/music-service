<?php

namespace App\Repository;

use App\Entity\RoleRight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class RoleRightRepository
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method RoleRight|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleRight|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleRight[]    findAll()
 * @method RoleRight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRightRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, RoleRight::class);

    }

}
