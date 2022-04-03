<?php

namespace App\Repository;

use App\Entity\PasswordReset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PasswordResetRepository.
 *
 * @package App\Repository
 *
 * @author  Codememory
 *
 * @method null|PasswordReset find($id, $lockMode = null, $lockVersion = null)
 * @method null|PasswordReset findOneBy(array $criteria, array $orderBy = null)
 * @method PasswordReset[]    findAll()
 * @method PasswordReset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswordResetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PasswordReset::class);
    }
}
