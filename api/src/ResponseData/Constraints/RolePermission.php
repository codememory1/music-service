<?php

namespace App\ResponseData\Constraints;

use App\Enum\RolePermissionEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

/**
 * Class RolePermission.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class RolePermission implements ConstraintInterface
{
    /**
     * @var array|RolePermissionEnum
     */
    public readonly array|RolePermissionEnum $permissions;

    /**
     * @param RolePermissionEnum $rolePermissionEnum
     */
    public function __construct(array|RolePermissionEnum $rolePermissionEnum)
    {
        $this->permissions = $rolePermissionEnum;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): string
    {
        return RolePermissionHandler::class;
    }
}