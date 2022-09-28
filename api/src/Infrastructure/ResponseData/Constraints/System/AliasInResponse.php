<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AliasInResponse
{
    public function __construct(
        public readonly string $alias
    ) {
    }
}