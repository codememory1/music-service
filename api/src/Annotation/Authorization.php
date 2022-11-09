<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class Authorization implements MethodAnnotationInterface
{
    public function __construct(
        public readonly bool $required = true
    ) {
    }

    public function getHandler(): string
    {
        return AuthorizationHandler::class;
    }
}