<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Security\AuthorizedUser;

/**
 * Class RoleHandler.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
class RoleHandler implements ConstraintHandlerInterface
{
    private AuthorizedUser $authorizedUser;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @param ConstraintInterface|Role $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        return $this->authorizedUser->isRole($constraint->role);
    }
}