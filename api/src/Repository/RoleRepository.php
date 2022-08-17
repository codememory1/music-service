<?php

namespace App\Repository;

use App\Entity\Role;

/**
 * @template-extends AbstractRepository<Role>
 */
final class RoleRepository extends AbstractRepository
{
    protected ?string $entity = Role::class;
    protected ?string $alias = 'r';
}
