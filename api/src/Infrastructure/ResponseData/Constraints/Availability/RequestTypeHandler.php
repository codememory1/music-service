<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintAvailabilityHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Rest\Http\Request;

final class RequestTypeHandler extends AbstractConstraintHandler implements ConstraintAvailabilityHandlerInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param RequestType $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        return $constraint->requestType->value === $this->request->getRequestType();
    }
}