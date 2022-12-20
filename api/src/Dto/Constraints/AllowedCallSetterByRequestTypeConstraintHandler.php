<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferCallSetterConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use App\Rest\Http\Request;

final class AllowedCallSetterByRequestTypeConstraintHandler extends AbstractDataTransferCallSetterConstraintHandler
{
    public function __construct(
        private readonly Request $request
    ) {
    }

    /**
     * @param AllowedCallSetterByRequestTypeConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): bool
    {
        return $this->request->getRequestType() === $constraint->requestType->value;
    }
}