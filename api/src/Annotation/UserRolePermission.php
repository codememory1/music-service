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
    /**
     * @var RolePermissionEnum
     */
    public readonly RolePermissionEnum $rolePermission;

    /**
     * @param RolePermissionEnum $rolePermissionEnum
     */
    public function __construct(RolePermissionEnum $rolePermissionEnum)
    {
        $this->rolePermission = $rolePermissionEnum;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): string
    {
        return UserRolePermissionHandler::class;
    }
}