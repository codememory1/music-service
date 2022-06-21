<?php

namespace App\Repository;

use App\Entity\Role;

/**
 * Class RoleRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<Role>
 *
 * @author  Codememory
 */
class RoleRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = Role::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'r';
}
