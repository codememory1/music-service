<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\RolePermission;
use Codememory\Dto\DataTransfer;

/**
 * @template-extends DataTransfer<RolePermission>
 */
final class UserRolePermissionDto extends DataTransfer
{
    #[DC\ToType]
    public array $permissions = [];
}