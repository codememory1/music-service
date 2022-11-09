<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Enum\RolePermissionEnum;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class UserRolePermission implements MethodAnnotationInterface
{
    public function __construct(
        public readonly RolePermissionEnum $rolePermission
    ) {
    }

    public function getHandler(): string
    {
        return UserRolePermissionHandler::class;
    }
}