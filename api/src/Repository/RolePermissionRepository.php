<?php

namespace App\Repository;

use App\Entity\RolePermission;

/**
 * @template-extends AbstractRepository<RolePermission>
 */
final class RolePermissionRepository extends AbstractRepository
{
    protected ?string $entity = RolePermission::class;
    protected ?string $alias = 'rp';
}
