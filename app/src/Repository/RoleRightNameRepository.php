<?php

namespace App\Repository;

use App\Entity\RoleRightName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class RoleRightNameRepository
 *
 * @package App\Repositor
 *
 * @author  Codememory
 *
 * @method RoleRightName|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleRightName|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleRightName[]    findAll()
 * @method RoleRightName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRightNameRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, RoleRightName::class);

    }

}
