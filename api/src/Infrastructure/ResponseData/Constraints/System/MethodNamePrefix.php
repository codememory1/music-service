<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class MethodNamePrefix
{
    public function __construct(
        public readonly string $prefix
    ) {
    }
}