<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\RolePermission;
use App\Infrastucture\Dto\AbstractDataTransfer;

/**
 * @template-extends AbstractDataTransfer<RolePermission>
 */
final class UserRolePermissionDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public array $permissions = [];
}