<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintSystemHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;

final class PrefixHandler extends AbstractConstraintSystemHandler
{
    /**
     * @param Prefix $constraint
     */
    public function handle(ConstraintInterface $constraint): void
    {
        if (null !== $constraint->methodPrefix) {
            $this->propertyDataDeterminant->getPropertyMethodRepository()->changePrefix($constraint->methodPrefix);

            $methodName = $this->propertyDataDeterminant->getPropertyMethodRepository()->getMethodName();

            $this->propertyDataDeterminant->setPropertyValue(
                method_exists($this->entityIteration, $methodName) ? $this->entityIteration->{$methodName}() : null
            );
        }

        if (null !== $constraint->responsePrefix) {
            $this->propertyDataDeterminant->setPropertyNameInResponse("is_{$this->propertyDataDeterminant->getPropertyNameInResponse()}");
        }
    }
}