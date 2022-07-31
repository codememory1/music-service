<?php

namespace App\Dto\Transfer;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\RolePermission;

/**
 * Class UserRolePermissionDTO.
 *
 * @package App\Dto\Transfer
 * @template-extends AbstractDataTransfer<RolePermission>
 *
 * @author  Codememory
 */
final class UserRolePermissionDto extends AbstractDataTransfer
{
    #[DtoConstraints\ToTypeConstraint]
    public array $permissions = [];
}