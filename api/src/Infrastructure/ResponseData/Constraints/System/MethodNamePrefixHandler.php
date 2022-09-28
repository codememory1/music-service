<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintSystemHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;

final class MethodNamePrefixHandler extends AbstractConstraintSystemHandler
{
    /**
     * @param MethodNamePrefix $constraint
     */
    public function handle(ConstraintInterface $constraint): void
    {
        $this->propertyDataDeterminant->getPropertyMethodRepository()->changePrefix($constraint->prefix);

        $methodName = $this->propertyDataDeterminant->getPropertyMethodRepository()->getMethodName();

        $this->propertyDataDeterminant->setPropertyValue(
            method_exists($this->entityIteration, $methodName) ? $this->entityIteration->{$methodName}() : null
        );
    }
}