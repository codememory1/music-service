<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Enum\RoleEnum;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Role implements ConstraintInterface
{
    public function __construct(
        public readonly RoleEnum $role
    ) {
    }

    public function getHandler(): string
    {
        return RoleHandler::class;
    }
}