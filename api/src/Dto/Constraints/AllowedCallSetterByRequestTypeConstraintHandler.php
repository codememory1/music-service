<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use App\Rest\Http\Request;

final class AllowedCallSetterByRequestTypeConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferCallSetterConstraintHandlerInterface
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