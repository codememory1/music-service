<?php

namespace App\Rest\ClassHelper;

use JetBrains\PhpStorm\Pure;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionFunctionAbstract;
use Reflector;

/**
 * Class AttributeReader.
 *
 * @package App\Rest\ClassHelper
 *
 * @author  Codememory
 */
class AttributeReader
{
    /**
     * @var ReflectionClass
     */
    private ReflectionClass $reflection;

    /**
     * @param ReflectionClass $reflectionClass
     */
    public function __construct(ReflectionClass $reflectionClass)
    {
        $this->reflection = $reflectionClass;
    }

    /**
     * @param string $attributeNamespace
     *
     * @return null|ReflectionAttribute
     */
    #[Pure]
    public function getAttributeClass(string $attributeNamespace): ?ReflectionAttribute
    {
        return $this->getAttribute($this->reflection, $attributeNamespace);
    }

    /**
     * @param string $method
     * @param string $attributeNamespace
     *
     * @throws ReflectionException
     *
     * @return null|ReflectionAttribute
     */
    #[Pure]
    public function getAttributeMethod(string $method, string $attributeNamespace): ?ReflectionAttribute
    {
        return $this->getAttribute($this->reflection->getMethod($method), $attributeNamespace);
    }

    /**
     * @param string $property
     * @param string $attributeNamespace
     *
     * @throws ReflectionException
     *
     * @return null|ReflectionAttribute
     */
    #[Pure]
    public function getAttributeProperty(string $property, string $attributeNamespace): ?ReflectionAttribute
    {
        return $this->getAttribute($this->reflection->getProperty($property), $attributeNamespace);
    }

    /**
     * @param ReflectionFunctionAbstract|Reflector $reflectionFunctionAbstract
     * @param string                               $attributeNamespace
     *
     * @return null|ReflectionAttribute
     */
    #[Pure]
    private function getAttribute(ReflectionFunctionAbstract|Reflector $reflectionFunctionAbstract, string $attributeNamespace): ?ReflectionAttribute
    {
        $attributes = $reflectionFunctionAbstract->getAttributes($attributeNamespace);

        if (count($attributes) > 0) {
            return $attributes[0];
        }

        return null;
    }
}