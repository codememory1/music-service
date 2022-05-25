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
    /**
     * @var string
     */
    public readonly string $methodName;

    /**
     * @var null|string
     */
    public readonly ?string $class;

    /**
     * @param string      $methodName
     * @param null|string $class
     */
    public function __construct(string $methodName, ?string $class = null)
    {
        $this->methodName = $methodName;
        $this->class = $class;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): string
    {
        return CallbackHandler::class;
    }
}