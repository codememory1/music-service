<?php

namespace App\Infrastructure\Reflection;

use function call_user_func;
use function is_object;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

final class Reflection
{
    public readonly ReflectionClass $reflectionClass;
    public readonly string $namespaceClass;

    /**
     * @throws ReflectionException
     */
    public function __construct(string|object $reflectionClass)
    {
        $this->reflectionClass = new ReflectionClass($reflectionClass);
        $this->namespaceClass = is_object($reflectionClass) ? $reflectionClass::class : $reflectionClass;
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