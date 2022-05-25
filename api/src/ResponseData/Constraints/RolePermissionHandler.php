<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Security\Auth\AuthorizedUser;

/**
 * Class RolePermissionHandler.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
class RolePermissionHandler implements ConstraintHandlerInterface
{
    /**
     * @var AuthorizedUser
     */
    private AuthorizedUser $authorizedUser;

    /**
     * @param AuthorizedUser $authorizedUser
     */
    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @inheritDoc
     *
     * @param ConstraintInterface|RolePermission $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        return $this->authorizedUser->hasRolePermission($constraint->permission);
    }
}