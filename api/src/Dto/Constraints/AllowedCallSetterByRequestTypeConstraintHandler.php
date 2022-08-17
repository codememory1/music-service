<?php

namespace App\Dto\Constraints;

use App\Dto\Interfaces\DataTransferCallSetterConstraintHandlerInterface;
use App\Dto\Interfaces\DataTransferConstraintInterface;
use App\Rest\Http\Request;

final class AllowedCallSetterByRequestTypeConstraintHandler extends AbstractDataTransferConstraintHandler implements DataTransferCallSetterConstraintHandlerInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param AllowedCallSetterByRequestTypeConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): bool
    {
        return $this->request->getRequestType() === $constraint->requestType->value;
    }
}