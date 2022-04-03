<?php

namespace App\Annotation;

use App\Entity\RolePermissionName;
use App\Enum\RolePermissionNameEnum;
use Attribute;

/**
 * Class UserRolePermission.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD)]
class UserRolePermission
{
    /**
     * @var RolePermissionName
     */
    public RolePermissionName $permissions;

    /**
     * @param RolePermissionNameEnum $permission
     */
    public function __construct(RolePermissionNameEnum $permission)
    {
        $rolePermissionNameEntity = new RolePermissionName();

        $rolePermissionNameEntity->setKey($permission->value);

        $this->permission = $rolePermissionNameEntity;
    }
}