<?php

namespace App\Infrastructure\ResponseData\Constraints\System;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintSystemHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;

final class AliasInResponseHandler extends AbstractConstraintSystemHandler
{
    /**
     * @param AliasInResponse $constraint
     */
    public function handle(ConstraintInterface $constraint): void
    {
        $this->propertyDataDeterminant->setPropertyNameInResponse($constraint->alias);
    }
}