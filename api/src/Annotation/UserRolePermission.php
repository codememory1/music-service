<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Enum\RolePermissionEnum;
use Attribute;

/**
 * Class UserRolePermission.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD)]
class UserRolePermission implements MethodAnnotationInterface
{
    public readonly RolePermissionEnum $rolePermission;

    public function __construct(RolePermissionEnum $rolePermissionEnum)
    {
        $this->rolePermission = $rolePermissionEnum;
    }

    public function getHandler(): string
    {
        return UserRolePermissionHandler::class;
    }
}