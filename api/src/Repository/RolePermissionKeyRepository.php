<?php

namespace App\Repository;

use App\Entity\RolePermissionKey;

/**
 * @template-extends AbstractRepository<RolePermissionKey>
 */
final class RolePermissionKeyRepository extends AbstractRepository
{
    protected ?string $entity = RolePermissionKey::class;
    protected ?string $alias = 'rpk';

    public function findByKey(?string $key): ?RolePermissionKey
    {
        return $this->findOneBy(['key' => $key]);
    }
}
