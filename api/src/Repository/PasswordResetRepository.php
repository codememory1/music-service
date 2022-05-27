<?php

namespace App\Repository;

use App\Entity\PasswordReset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class PasswordResetRepository
 *
 * @package App\Repository
 * @template-extends AbstractRepository<PasswordReset>
 *
 * @author  Codememory
 */
class PasswordResetRepository extends AbstractRepository
{
    /**
     * @inheritDoc 
     */
    protected ?string $entity = PasswordReset::class;
}
