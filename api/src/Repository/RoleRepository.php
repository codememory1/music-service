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
    protected ?string $entity = Role::class;
    protected ?string $alias = 'r';
}
