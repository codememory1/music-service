<?php

namespace App\ResponseData\Constraints;

use App\Enum\RoleEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Role implements ConstraintInterface
{
    public readonly RoleEnum $role;

    public function __construct(RoleEnum $roleEnum)
    {
        $this->role = $roleEnum;
    }

    public function getHandler(): string
    {
        return RoleHandler::class;
    }
}