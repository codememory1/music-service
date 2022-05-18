<?php

namespace App\Annotation;

use Attribute;

/**
 * Class EntityNotFound
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PARAMETER)]
class EntityNotFound
{
    /**
     * @var string
     */
    public readonly string $class;

    /**
     * @var string
     */
    public readonly string $method;

    /**
     * @param string $class
     * @param string $method
     */
    public function __construct(string $class, string $method)
    {
        $this->class = $class;
        $this->method = $method;
    }
}