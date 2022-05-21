<?php

namespace App\Repository;

use App\Entity\RolePermissionKey;

/**
 * Class RolePermissionKeyRepository
 *
 * @package App\Repository
 * @template-extends AbstractRepository<RolePermissionKey>
 *
 * @author  codememory
 */
class RolePermissionKeyRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    protected ?string $entity = RolePermissionKey::class;
}
