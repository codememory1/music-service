<?php

namespace App\Repository;

use App\Entity\RolePermission;

/**
 * Class RolePermissionRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<RolePermission>
 *
 * @author  Codememory
 */
class RolePermissionRepository extends AbstractRepository
{
    protected ?string $entity = RolePermission::class;
    protected ?string $alias = 'rp';
}
