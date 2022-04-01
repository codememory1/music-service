<?php

namespace App\Rest\ClassHelper;

use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;

/**
 * Class ClassMetadata
 *
 * @package App\Rest\ClassHelper
 *
 * @author  Codememory
 */
class ClassMetadata
{

	/**
	 * @var ReflectionClass
	 */
	public readonly ReflectionClass $reflection;

	/**
	 * @var AttributeReader
	 */
	public readonly AttributeReader $attributeReader;

	/**
	 * @param string|object $classNamespace
	 *
	 * @throws ReflectionException
	 */
	public function __construct(string|object $classNamespace)
	{

		$this->reflection = new ReflectionClass($classNamespace);
		$this->attributeReader = new AttributeReader($this->reflection);

	}

	/**
	 * @return string
	 */
	#[Pure]
	public function className(): string
	{

		return $this->reflection->getShortName();

	}

}