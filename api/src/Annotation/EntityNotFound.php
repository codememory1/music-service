<?php

namespace App\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class EntityNotFound
{
    public function __construct(
        public readonly string $class,
        public readonly string $method
    ) {
    }
}