<?php

namespace App\Infrastructure\Reflection;

use ReflectionProperty;

class Reflection
{
    public readonly string $namespaceClass;

    public function __construct(
        public readonly string|object $reflectionClass
    ) {
        $this->namespaceClass = is_object($this->reflectionClass) ? $this->reflectionClass::class : $this->reflectionClass;
    }

    public function getStrictlyClassProperties(?callable $filter = null): array
    {
        $namespaceClass = $this->namespaceClass;

        return array_filter($this->reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE), static function(ReflectionProperty $property) use ($namespaceClass, $filter) {
            $filter = null === $filter || call_user_func($filter, $property);

            return $property->class === $namespaceClass && $filter;
        });
    }

    public function getProperty(array $properties, string $name): ?ReflectionProperty
    {
        return array_filter($properties, static fn(ReflectionProperty $property) => $property->getName() === $name)[0] ?? null;
    }
}