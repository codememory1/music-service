<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Enum\RoleEnum;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class UserRole implements MethodAnnotationInterface
{
    public function __construct(
        public readonly RoleEnum $role
    ) {}

    public function getHandler(): string
    {
        return UserRoleHandler::class;
    }
}