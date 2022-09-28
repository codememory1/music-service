<?php

namespace App\Infrastructure\ResponseData\Interfaces;

use ReflectionProperty;

interface ConstraintSystemHandlerInterface extends ConstraintHandlerInterface
{
    public function setReflectionProperty(ReflectionProperty $property): self;

    public function getPropertyDataDeterminant(): PropertyDataDeterminantInterface;

    public function setPropertyDataDeterminant(PropertyDataDeterminantInterface $propertyDataDeterminant): self;

    public function handle(ConstraintInterface $constraint): void;
}