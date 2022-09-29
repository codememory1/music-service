<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AliasInResponse implements ConstraintInterface
{
    public function __construct(
        public readonly string $alias
    ) {
    }

    public function getHandler(): string
    {
        return AliasInResponseHandler::class;
    }
}