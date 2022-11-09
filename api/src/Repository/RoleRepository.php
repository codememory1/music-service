<?php

namespace App\Repository;

use App\Entity\Role;
use App\Enum\RoleEnum;

/**
 * @template-extends AbstractRepository<Role>
 */
final class RoleRepository extends AbstractRepository
{
    protected ?string $entity = Role::class;
    protected ?string $alias = 'r';

    public function findByKey(RoleEnum $role): ?Role
    {
        return $this->findOneBy(['key' => $role->name]);
    }
}
