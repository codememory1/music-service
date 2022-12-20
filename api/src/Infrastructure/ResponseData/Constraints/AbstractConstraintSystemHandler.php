<?php

namespace App\Infrastructure\ResponseData\Constraints;

use App\Infrastructure\ResponseData\Interfaces\ConstraintSystemHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\PropertyDataDeterminantInterface;
use ReflectionProperty;

abstract class AbstractConstraintSystemHandler extends AbstractConstraintHandler implements ConstraintSystemHandlerInterface
{
    protected ?ReflectionProperty $property = null;
    protected ?PropertyDataDeterminantInterface $propertyDataDeterminant = null;

    public function setReflectionProperty(ReflectionProperty $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getPropertyDataDeterminant(): PropertyDataDeterminantInterface
    {
        return $this->propertyDataDeterminant;
    }

    public function setPropertyDataDeterminant(PropertyDataDeterminantInterface $propertyDataDeterminant): ConstraintSystemHandlerInterface
    {
        $this->propertyDataDeterminant = $propertyDataDeterminant;

        return $this;
    }
}