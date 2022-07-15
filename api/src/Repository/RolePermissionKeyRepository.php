<?php

namespace App\Repository;

use App\Entity\RolePermissionKey;

/**
 * Class RolePermissionKeyRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<RolePermissionKey>
 *
 * @author  Codememory
 */
class RolePermissionKeyRepository extends AbstractRepository
{
    protected ?string $entity = RolePermissionKey::class;
    protected ?string $alias = 'rpk';
}
