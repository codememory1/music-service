<?php

namespace App\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class EntityNotFound
{
    public readonly string $class;
    public readonly string $method;

    public function __construct(string $class, string $method)
    {
        $this->class = $class;
        $this->method = $method;
    }
}