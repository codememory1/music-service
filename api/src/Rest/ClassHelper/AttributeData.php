<?php

namespace App\Rest\ClassHelper;

use JetBrains\PhpStorm\Pure;
use ReflectionAttribute;

/**
 * Class AttributeData.
 *
 * @package App\Rest\ClassHelper
 *
 * @author  Codememory
 */
class AttributeData
{
    /**
     * @var ReflectionAttribute
     */
    public readonly ReflectionAttribute $reflectionAttribute;

    /**
     * @var array
     */
    public readonly array $arguments;

    /**
     * @param ReflectionAttribute $reflectionAttribute
     */
    #[Pure]
    public function __construct(ReflectionAttribute $reflectionAttribute)
    {
        $this->reflectionAttribute = $reflectionAttribute;
        $this->attributeArguments = $this->reflectionAttribute->getArguments();
    }

    /**
     * @param array $arguments
     *
     * @return object
     */
    public function instance(array $arguments = []): object
    {
        $namespace = $this->getNamespace();

        return new $namespace(...$arguments);
    }

    /**
     * @return string
     */
    #[Pure]
    public function getNamespace(): string
    {
        return $this->reflectionAttribute->getName();
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->arguments[$name];
    }
}