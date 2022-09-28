<?php

namespace App\Infrastructure\Repository;

use JetBrains\PhpStorm\Pure;
use ReflectionProperty;
use function Symfony\Component\String\u;

final class AllowedPropertyRepository
{
    /**
     * @param array<int, PropertyInterceptorRepository> $interceptors
     */
    public function __construct(
        public readonly ReflectionProperty $property,
        public readonly array $interceptors = []
    ) {
    }

    #[Pure]
    public function getPropertyName(): string
    {
        return $this->property->getName();
    }

    public function getSetterMethodName(): string
    {
        return $this->toCamel("set_{$this->getPropertyName()}");
    }

    public function getGetterMethodName(): string
    {
        return $this->toCamel("get_{$this->getPropertyName()}");
    }

    public function getIsMethodName(): string
    {
        return $this->toCamel("is_{$this->getPropertyName()}");
    }

    public function getCustomMethodName(string $prefix): string
    {
        return $this->toCamel("{$prefix}_{$this->getPropertyName()}");
    }

    private function toCamel(string $string): string
    {
        return u($string)->camel()->toString();
    }
}