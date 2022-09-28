<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class MethodNamePrefix implements ConstraintInterface
{
    public function __construct(
        public readonly string $prefix
    ) {
    }

    public function getHandler(): string
    {
        return MethodNamePrefixHandler::class;
    }
}