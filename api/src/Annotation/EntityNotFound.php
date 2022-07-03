<?php

namespace App\Annotation;

use Attribute;

/**
 * Class EntityNotFound.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class EntityNotFound
{
    public readonly string $class;
    public readonly string $method;

    public function __construct(string $class, string $method)
    {
        $this->class = $class;
        $this->method = $method;
    }
}