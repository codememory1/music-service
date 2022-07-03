<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Rest\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class RequestTypeHandler.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
class RequestTypeHandler implements ConstraintHandlerInterface
{
    private ParameterBag $attributes;

    public function __construct(Request $request)
    {
        $this->attributes = $request->request->attributes;
    }

    /**
     * @param ConstraintInterface|RequestType $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        return $constraint->requestType === $this->attributes->get('request_type');
    }
}