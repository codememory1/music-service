<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Rest\Http\Request;

final class RequestTypeHandler implements ConstraintHandlerInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param ConstraintInterface|RequestType $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        return $constraint->requestType === $this->request->getRequestType();
    }
}