<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

/**
 * Class Callback.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Callback implements ConstraintInterface
{
    public readonly string $methodName;
    public readonly ?string $class;

    public function __construct(string $methodName, ?string $class = null)
    {
        $this->methodName = $methodName;
        $this->class = $class;
    }

    public function getHandler(): string
    {
        return CallbackHandler::class;
    }
}