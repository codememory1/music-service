<?php

namespace App\Infrastructure\ResponseData\Repository;

use JetBrains\PhpStorm\Pure;
use ReflectionProperty;
use function Symfony\Component\String\u;

final class AllowedPropertyRepository
{
    public function __construct(
        public readonly ReflectionProperty $property
    ) {
    }

    #[Pure]
    public function getPropertyName(): string
    {
        return $this->property->getName();
    }

    public function getPropertyNameInResponse(): string
    {
        return u($this->getPropertyName())->snake()->toString();
    }
}