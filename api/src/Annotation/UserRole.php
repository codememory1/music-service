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
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class UserRole implements MethodAnnotationInterface
{
    public readonly RoleEnum $role;

    public function __construct(RoleEnum $roleEnum)
    {
        $this->role = $roleEnum;
    }

    public function getHandler(): string
    {
        return UserRoleHandler::class;
    }
}