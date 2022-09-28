<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
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