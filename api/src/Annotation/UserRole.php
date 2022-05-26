<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Enum\RoleEnum;
use Attribute;

/**
 * Class UserRole.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD)]
class UserRole implements MethodAnnotationInterface
{
    /**
     * @var RoleEnum
     */
    public readonly RoleEnum $role;

    /**
     * @param RoleEnum $rolePermissionEnum
     */
    public function __construct(RoleEnum $roleEnum)
    {
        $this->role = $roleEnum;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): string
    {
        return UserRoleHandler::class;
    }
}