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
    /**
     * @var ParameterBag
     */
    private ParameterBag $attributes;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->attributes = $request->request->attributes;
    }

    /**
     * @inheritDoc
     *
     * @param ConstraintInterface|RequestType $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        return $constraint->requestType === $this->attributes->get('request_type');
    }
}