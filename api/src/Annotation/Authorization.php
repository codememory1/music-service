<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use Attribute;

/**
 * Class Authorization.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Authorization implements MethodAnnotationInterface
{
    public readonly bool $required;

    public function __construct(bool $required = true)
    {
        $this->required = $required;
    }

    public function getHandler(): string
    {
        return AuthorizationHandler::class;
    }
}