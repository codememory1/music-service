<?php

namespace App\ResponseData\Constraints;

use App\Enum\RolePermissionEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class RolePermission implements ConstraintInterface
{
    public readonly array|RolePermissionEnum $permissions;

    public function __construct(array|RolePermissionEnum $rolePermissionEnum)
    {
        $this->permissions = $rolePermissionEnum;
    }

    public function getHandler(): string
    {
        return RolePermissionHandler::class;
    }
}