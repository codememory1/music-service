<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintSystemHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;

final class AsCustomPropertyHandler extends AbstractConstraintSystemHandler
{
    /**
     * @param AsCustomProperty $constraint
     */
    public function handle(ConstraintInterface $constraint): void
    {
        $this->propertyDataDeterminant->setPropertyValue(null);
    }
}