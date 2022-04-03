<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class RoleRepository.
 *
 * @package App\Repositor
 *
 * @author  Codememory
 *
 * @method null|Role find($id, $lockMode = null, $lockVersion = null)
 * @method null|Role findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }
}
