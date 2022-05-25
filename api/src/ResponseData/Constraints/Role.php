<?php

namespace App\ResponseData\Constraints;

use App\Enum\RoleEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

/**
 * Class Role.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Role implements ConstraintInterface
{
    /**
     * @var RoleEnum
     */
    public readonly RoleEnum $role;

    /**
     * @param RoleEnum $roleEnum
     */
    public function __construct(RoleEnum $roleEnum)
    {
        $this->role = $roleEnum;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): string
    {
        return RoleHandler::class;
    }
}