<?php

namespace App\Repository;

use App\Entity\RolePermissionName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class RolePermissionNameRepository.
 *
 * @package App\Repositor
 *
 * @author  Codememory
 *
 * @method null|RolePermissionName find($id, $lockMode = null, $lockVersion = null)
 * @method null|RolePermissionName findOneBy(array $criteria, array $orderBy = null)
 * @method RolePermissionName[]    findAll()
 * @method RolePermissionName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolePermissionNameRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RolePermissionName::class);
    }
}
