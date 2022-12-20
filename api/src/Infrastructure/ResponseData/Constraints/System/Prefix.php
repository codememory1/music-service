<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Prefix implements ConstraintInterface
{
    public function __construct(
        public readonly ?string $methodPrefix = null,
        public readonly ?string $responsePrefix = null,
    ) {
    }

    public function getHandler(): string
    {
        return PrefixHandler::class;
    }
}